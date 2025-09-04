<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to DB
$conn = mysqli_connect("localhost", "root", "", "resume");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_email = $_SESSION['email'] ?? '';
$resume_id = isset($_GET['resume_id']) ? intval($_GET['resume_id']) : 0;
$selected_template = $_GET['template'] ?? 'template1';

// ✅ ONLY save to history when action=save is explicitly set
if (isset($_GET['action']) && $_GET['action'] === 'save' && $resume_id > 0 && $user_email) {
    $check = mysqli_query($conn, "SELECT id FROM resumes WHERE id=$resume_id AND email='$user_email'");
    if (mysqli_num_rows($check) > 0) {
        // Check if this combination already exists to avoid duplicates
        $existing = mysqli_query($conn, "SELECT id FROM history WHERE resume_id=$resume_id AND template='$selected_template'");
        if (mysqli_num_rows($existing) == 0) {
            $sql = "INSERT INTO history (resume_id, template) VALUES ($resume_id, '$selected_template')";
            mysqli_query($conn, $sql);
            $save_success = true;
        } else {
            $already_saved = true;
        }
    }
}

// Get user_id from GET param 'resume_id'
$user_id = isset($_GET['resume_id']) ? intval($_GET['resume_id']) : 0;
if ($user_id === 0) {
    die("Invalid user ID");
}

// Validate template exists
$allowed_templates = [
    'template1', 'template2', 'template3', 'template4', 'template5',
    'template6', 'template7', 'template8', 'template9', 'template10',
    'template11', 'template12', 'template13', 'template14', 'template15'
];
if (!in_array($selected_template, $allowed_templates)) {
    $selected_template = 'template1';
}

// Fetch resume data with proper error handling
$sql = "SELECT * FROM resumes WHERE id = $user_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("No resume found for this user.");
}

$resume = mysqli_fetch_assoc($result);

// FIXED: Fetch related data from separate tables instead of JSON fields
function fetchResumeData($conn, $resume_id) {
    $data = [];
    
    // Fetch education/diplomas
    $edu_query = "SELECT * FROM education WHERE resume_id = $resume_id ORDER BY id";
    $edu_result = mysqli_query($conn, $edu_query);
    $data['diplomas'] = [];
    if ($edu_result) {
        while ($row = mysqli_fetch_assoc($edu_result)) {
            $data['diplomas'][] = [
                'institution' => $row['institution_name'],
                'degree' => $row['degree_program'] ?: 'N/A',
                'duration' => $row['duration'],
                'type' => $row['education_type']
            ];
        }
    }
    
    // Fetch experience
    $exp_query = "SELECT * FROM experience WHERE resume_id = $resume_id ORDER BY id";
    $exp_result = mysqli_query($conn, $exp_query);
    $data['experience'] = [];
    if ($exp_result) {
        while ($row = mysqli_fetch_assoc($exp_result)) {
            $data['experience'][] = [
                'title' => $row['job_title'],
                'company' => $row['company_name'],
                'duration' => $row['duration'],
                'description' => $row['job_description']
            ];
        }
    }
    
    // Fetch skills
    $skills_query = "SELECT * FROM skills WHERE resume_id = $resume_id ORDER BY id";
    $skills_result = mysqli_query($conn, $skills_query);
    $data['skills'] = [];
    if ($skills_result) {
        while ($row = mysqli_fetch_assoc($skills_result)) {
            $data['skills'][] = [
                'name' => $row['skill_name']
            ];
        }
    }
    
    // Fetch languages
    $lang_query = "SELECT * FROM languages WHERE resume_id = $resume_id ORDER BY id";
    $lang_result = mysqli_query($conn, $lang_query);
    $data['languages'] = [];
    if ($lang_result) {
        while ($row = mysqli_fetch_assoc($lang_result)) {
            $data['languages'][] = [
                'name' => $row['language_name'],
                'proficiency' => $row['proficiency_level']
            ];
        }
    }
    
    // Fetch projects
    $proj_query = "SELECT * FROM projects WHERE resume_id = $resume_id ORDER BY id";
    $proj_result = mysqli_query($conn, $proj_query);
    $data['projects'] = [];
    if ($proj_result) {
        while ($row = mysqli_fetch_assoc($proj_result)) {
            $data['projects'][] = [
                'title' => $row['project_title'],
                'duration' => $row['duration'],
                'description' => $row['project_description'],
                'link' => $row['project_link']
            ];
        }
    }
    
    // Fetch achievements
    $achieve_query = "SELECT * FROM achievements WHERE resume_id = $resume_id ORDER BY id";
    $achieve_result = mysqli_query($conn, $achieve_query);
    $data['achievements'] = [];
    if ($achieve_result) {
        while ($row = mysqli_fetch_assoc($achieve_result)) {
            $data['achievements'][] = [
                'description' => $row['achievement_description']
            ];
        }
    }
    
    return $data;
}

// Get the properly structured data
$resumeData = fetchResumeData($conn, $user_id);

// FIXED: Enhanced scoring function with proper validation
function calculateResumeScore($resume, $resumeData) {
    $totalScore = 0;
    $maxScore = 100;
    $details = [];
    
    // Debug: Log what we're working with
    error_log("Calculating score for resume ID: " . ($resume['id'] ?? 'unknown'));
    error_log("Education count: " . count($resumeData['diplomas']));
    error_log("Experience count: " . count($resumeData['experience']));
    error_log("Skills count: " . count($resumeData['skills']));
    
    // 1. Personal Information (20 points)
    $personalScore = 0;
    $personalFeedback = [];
    
    if (!empty(trim($resume['full_name'] ?? ''))) {
        $personalScore += 5;
    } else {
        $personalFeedback[] = 'Add full name';
    }
    
    if (!empty(trim($resume['email'] ?? '')) && filter_var($resume['email'], FILTER_VALIDATE_EMAIL)) {
        $personalScore += 5;
    } else {
        $personalFeedback[] = 'Add valid email';
    }
    
    if (!empty(trim($resume['phone'] ?? ''))) {
        $personalScore += 5;
    } else {
        $personalFeedback[] = 'Add phone number';
    }
    
    if (!empty(trim($resume['address'] ?? ''))) {
        $personalScore += 3;
    } else {
        $personalFeedback[] = 'Add address';
    }
    
    if (!empty(trim($resume['linkedin'] ?? ''))) {
        $personalScore += 2;
    } else {
        $personalFeedback[] = 'Add LinkedIn profile';
    }
    
    $details['personal_info'] = [
        'score' => $personalScore,
        'max' => 20,
        'feedback' => empty($personalFeedback) ? 'Complete contact information' : implode(', ', $personalFeedback)
    ];
    $totalScore += $personalScore;

    // 2. Professional Summary/Objective (15 points)
    $summaryScore = 0;
    $summaryText = trim($resume['professional_summary'] ?? $resume['career_objective'] ?? '');
    
    if (!empty($summaryText)) {
        $wordCount = str_word_count($summaryText);
        if ($wordCount >= 20 && $wordCount <= 100) {
            $summaryScore = 15; // Perfect length
        } elseif ($wordCount >= 10) {
            $summaryScore = 12; // Good but could be better
        } else {
            $summaryScore = 8; // Too short
        }
        $summaryFeedback = "Good professional summary ($wordCount words)";
    } else {
        $summaryFeedback = 'Add a professional summary or career objective';
    }
    
    $details['summary'] = [
        'score' => $summaryScore,
        'max' => 15,
        'feedback' => $summaryFeedback
    ];
    $totalScore += $summaryScore;

    // 3. Education (20 points)
    $educationScore = 0;
    $educationCount = count($resumeData['diplomas']);
    
    if ($educationCount > 0) {
        // Score based on number and completeness of education entries
        $educationScore = min(20, $educationCount * 7); // Up to 20 points
        
        // Bonus points for complete entries
        $completeEntries = 0;
        foreach ($resumeData['diplomas'] as $edu) {
            if (!empty($edu['institution']) && !empty($edu['duration'])) {
                $completeEntries++;
            }
        }
        
        if ($completeEntries == $educationCount) {
            $educationScore = min(20, $educationScore + 3); // Bonus for completeness
        }
        
        $educationFeedback = "Education section complete ($educationCount entries)";
    } else {
        $educationFeedback = 'Add your education details';
    }
    
    $details['education'] = [
        'score' => $educationScore,
        'max' => 20,
        'feedback' => $educationFeedback
    ];
    $totalScore += $educationScore;

    // 4. Experience (25 points) - Consider freshie status
    $experienceScore = 0;
    $experienceCount = count($resumeData['experience']);
    $isFreshie = !empty($resume['is_freshie']);
    
    if ($isFreshie) {
        // For freshies, reduce emphasis on work experience
        if ($experienceCount > 0) {
            $experienceScore = min(15, $experienceCount * 5); // Max 15 for freshies
            $experienceFeedback = "Work experience added (entry-level)";
        } else {
            $experienceScore = 10; // Give some points even without experience
            $experienceFeedback = 'Entry-level - focus on projects and education';
        }
    } else {
        // For experienced professionals
        if ($experienceCount > 0) {
            $experienceScore = min(25, $experienceCount * 6);
            
            // Bonus for detailed descriptions
            $detailedCount = 0;
            foreach ($resumeData['experience'] as $exp) {
                if (!empty($exp['description']) && str_word_count($exp['description']) >= 10) {
                    $detailedCount++;
                }
            }
            
            if ($detailedCount > 0) {
                $experienceScore = min(25, $experienceScore + 3);
            }
            
            $experienceFeedback = "Experience section complete ($experienceCount positions)";
        } else {
            $experienceFeedback = 'Add your work experience';
        }
    }
    
    $details['experience'] = [
        'score' => $experienceScore,
        'max' => 25,
        'feedback' => $experienceFeedback
    ];
    $totalScore += $experienceScore;

    // 5. Skills (15 points)
    $skillsScore = 0;
    $skillsCount = count($resumeData['skills']);
    
    if ($skillsCount > 0) {
        if ($skillsCount >= 5) {
            $skillsScore = 15; // Perfect
        } elseif ($skillsCount >= 3) {
            $skillsScore = 12; // Good
        } else {
            $skillsScore = 8; // Needs more
        }
        $skillsFeedback = "Skills listed ($skillsCount skills)";
    } else {
        $skillsFeedback = 'Add your skills';
    }
    
    $details['skills'] = [
        'score' => $skillsScore,
        'max' => 15,
        'feedback' => $skillsFeedback
    ];
    $totalScore += $skillsScore;

    // 6. Additional Sections (15 points)
    $additionalScore = 0;
    $additionalFeedback = [];
    
    // Languages (5 points)
    if (count($resumeData['languages']) > 0) {
        $additionalScore += 5;
        $additionalFeedback[] = 'Languages added (' . count($resumeData['languages']) . ')';
    } else {
        $additionalFeedback[] = 'Consider adding languages';
    }
    
    // Projects (5 points)
    if (count($resumeData['projects']) > 0) {
        $additionalScore += 5;
        $additionalFeedback[] = 'Projects added (' . count($resumeData['projects']) . ')';
    } else {
        $additionalFeedback[] = 'Consider adding projects';
    }
    
    // Achievements/Certifications (5 points)
    $hasAchievements = count($resumeData['achievements']) > 0;
    $hasCertifications = !empty(trim($resume['certifications'] ?? ''));
    
    if ($hasAchievements || $hasCertifications) {
        $additionalScore += 5;
        $items = [];
        if ($hasAchievements) $items[] = 'achievements (' . count($resumeData['achievements']) . ')';
        if ($hasCertifications) $items[] = 'certifications';
        $additionalFeedback[] = 'Added ' . implode(' and ', $items);
    } else {
        $additionalFeedback[] = 'Consider adding achievements or certifications';
    }
    
    $details['additional'] = [
        'score' => $additionalScore,
        'max' => 15,
        'feedback' => implode(', ', $additionalFeedback)
    ];
    $totalScore += $additionalScore;

    // Calculate percentage
    $percentage = round(($totalScore / $maxScore) * 100);
    
    // Generate overall feedback based on score
    $overallFeedback = '';
    if ($percentage >= 90) {
        $overallFeedback = 'Excellent resume! Very comprehensive and professional.';
    } elseif ($percentage >= 80) {
        $overallFeedback = 'Great resume! Minor improvements could make it even better.';
    } elseif ($percentage >= 70) {
        $overallFeedback = 'Good resume with solid foundation. Consider adding more details.';
    } elseif ($percentage >= 60) {
        $overallFeedback = 'Decent resume but needs more comprehensive information.';
    } else {
        $overallFeedback = 'Resume needs significant improvements to be competitive.';
    }

    return [
        'total' => $totalScore,
        'max' => $maxScore,
        'details' => $details,
        'percentage' => $percentage,
        'overall_feedback' => $overallFeedback
    ];
}

// Enhanced AI-powered scoring (if API is available)
function calculateResumeScoreWithAI($resume, $resumeData) {
    // Prepare data for AI analysis
    $aiResumeData = [
        'personal_info' => [
            'full_name' => $resume['full_name'] ?? '',
            'email' => $resume['email'] ?? '',
            'phone' => $resume['phone'] ?? '',
            'address' => $resume['address'] ?? '',
            'linkedin' => $resume['linkedin'] ?? '',
            'website' => $resume['website'] ?? ''
        ],
        'professional_summary' => $resume['professional_summary'] ?? '',
        'career_objective' => $resume['career_objective'] ?? '',
        'education' => $resumeData['diplomas'],
        'experience' => $resumeData['experience'],
        'skills' => $resumeData['skills'],
        'languages' => $resumeData['languages'],
        'projects' => $resumeData['projects'],
        'achievements' => $resumeData['achievements'],
        'is_freshie' => !empty($resume['is_freshie']),
        'professional_field' => $resume['professional_field'] ?? ''
    ];

    // Try AI API call (implement based on your AI service)
    $aiScore = callAIScoringAPI($aiResumeData);

    // If AI API fails, fall back to manual scoring
    if ($aiScore === false) {
        return calculateResumeScore($resume, $resumeData);
    }

    return $aiScore;
}

// AI API Integration Function (enhanced)
function callAIScoringAPI($resumeData) {
    // This is still a placeholder - implement with your actual AI service
    // For now, return false to use manual scoring
    
    // Example OpenAI integration (uncomment to use):
    /*
    $api_key = "YOUR_OPENAI_API_KEY";
    
    if (empty($api_key) || $api_key === "YOUR_OPENAI_API_KEY") {
        return false; // No API key, use manual scoring
    }
    
    $prompt = "Analyze this resume data and provide a score out of 100 with detailed feedback: " . json_encode($resumeData);
    
    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a professional resume scorer. Provide scores and constructive feedback.'],
            ['role' => 'user', 'content' => $prompt]
        ],
        'max_tokens' => 800,
        'temperature' => 0.3
    ];
    
    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200 && !empty($response)) {
        $result = json_decode($response, true);
        if (isset($result['choices'][0]['message']['content'])) {
            // Parse AI response and format it properly
            return parseAIScoreResponse($result['choices'][0]['message']['content']);
        }
    }
    */
    
    return false; // Use manual scoring
}

// Parse AI score response (for when you implement real AI)
function parseAIScoreResponse($aiResponse) {
    // This would parse the AI response and format it to match our expected structure
    // Implementation depends on how your AI service formats responses
    
    // For now, return false to use manual scoring
    return false;
}

// Calculate the resume score using the enhanced system
try {
    $resumeScore = calculateResumeScoreWithAI($resume, $resumeData);
    
    // Add debug information
    error_log("Resume scoring completed:");
    error_log("Total score: " . $resumeScore['total']);
    error_log("Percentage: " . $resumeScore['percentage'] . "%");
    error_log("Details: " . print_r($resumeScore['details'], true));
    
} catch (Exception $e) {
    error_log("Scoring error: " . $e->getMessage());
    // Fallback scoring if there's an error
    $resumeScore = [
        'total' => 0,
        'max' => 100,
        'percentage' => 0,
        'details' => [
            'error' => [
                'score' => 0,
                'max' => 100,
                'feedback' => 'Error calculating score: ' . $e->getMessage()
            ]
        ],
        'overall_feedback' => 'Unable to calculate score due to technical error.'
    ];
}

// Function to get template info (unchanged)
function getTemplateInfo($template) {
    $templates = [
        'template1' => [
            'name' => 'Modern Professional',
            'description' => 'Clean, modern design perfect for corporate positions.',
            'tags' => ['Professional', 'Clean'],
            'image' => 'template1-preview.jpg'
        ],
        'template2' => [
            'name' => 'Creative Designer',
            'description' => 'Bold layout for creative professionals.',
            'tags' => ['Creative', 'Bold'],
            'image' => 'template2-preview.jpg'
        ],
        'template3' => [
            'name' => 'Minimal Clean',
            'description' => 'Simple, distraction-free design.',
            'tags' => ['Simple', 'Clean'],
            'image' => 'template3-preview.jpg'
        ],
        'template4' => [
            'name' => 'Executive Style',
            'description' => 'Professional layout for senior positions.',
            'tags' => ['Executive', 'Professional'],
            'image' => 'template4-preview.jpg'
        ],
        'template5' => [
            'name' => 'Modern Compact',
            'description' => 'Space-efficient modern design.',
            'tags' => ['Compact', 'Modern'],
            'image' => 'template5-preview.jpg'
        ],
        'template6' => [
            'name' => 'Academic Scholar',
            'description' => 'Formal design for academic and research positions.',
            'tags' => ['Academic', 'Formal'],
            'image' => 'template6-preview.jpg'
        ],
        'template7' => [
            'name' => 'Tech Innovator',
            'description' => 'Modern layout for tech professionals.',
            'tags' => ['Technology', 'Modern'],
            'image' => 'template7-preview.jpg'
        ],
        'template8' => [
            'name' => 'Artistic Portfolio',
            'description' => 'Creative design for artists and designers.',
            'tags' => ['Creative', 'Artistic'],
            'image' => 'template8-preview.jpg'
        ],
        'template9' => [
            'name' => 'Corporate Executive',
            'description' => 'Professional layout for C-level executives.',
            'tags' => ['Executive', 'Corporate'],
            'image' => 'template9-preview.jpg'
        ],
        'template10' => [
            'name' => 'Minimalist Elegance',
            'description' => 'Simple yet elegant design.',
            'tags' => ['Minimalist', 'Elegant'],
            'image' => 'template10-preview.jpg'
        ],
        'template11' => [
            'name' => 'Creative Freelancer',
            'description' => 'Bold design for creative freelancers.',
            'tags' => ['Freelance', 'Creative'],
            'image' => 'template11-preview.jpg'
        ],
        'template12' => [
            'name' => 'Modern Developer',
            'description' => 'Tech-focused layout for developers.',
            'tags' => ['Developer', 'Technical'],
            'image' => 'template12-preview.jpg'
        ],
        'template13' => [
            'name' => 'Professional Manager',
            'description' => 'Clean design for management positions.',
            'tags' => ['Management', 'Professional'],
            'image' => 'template13-preview.jpg'
        ],
        'template14' => [
            'name' => 'Creative Marketer',
            'description' => 'Innovative layout for marketing professionals.',
            'tags' => ['Marketing', 'Creative'],
            'image' => 'template14-preview.jpg'
        ],
        'template15' => [
            'name' => 'Modern Educator',
            'description' => 'Structured design for education professionals.',
            'tags' => ['Education', 'Structured'],
            'image' => 'template15-preview.jpg'
        ]
    ];

    return $templates[$template] ?? $templates['template1'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Resume - <?php echo htmlspecialchars($resume['full_name'] ?? 'Resume'); ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/preview.css">
    <style>
        :root {
            --primary: #008080;
            --secondary: #FFFFFF;
            --text: #2D3436;
            --text-light: #FFFFFF;
            --accent: #006666;
            --highlight: #00A3A3;
            --success: #008080;
            --form-bg: #F8F9FA;
            --border: #E0E0E0;
            --shadow: 0 10px 30px rgba(0, 128, 128, 0.1);
            --shadow-hover: 0 20px 40px rgba(0, 128, 128, 0.15);
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            --border-radius: 16px;
            --resume-bg: #f0f8f8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--resume-bg);
            color: var(--text);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: var(--border-radius);
            color: var(--text-light);
            box-shadow: var(--shadow);
            position: relative;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .toggle-view-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--border-radius);
            color: var(--text-light);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .toggle-view-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .main-container {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
            transition: var(--transition);
        }

        .left-panel {
            width: 300px;
            transition: var(--transition);
        }

        .resume-container {
            max-width: 850px;
            flex: 1;
            background: var(--secondary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            position: relative;
            transition: var(--transition);
        }

        .right-panel {
            width: 300px;
            transition: var(--transition);
        }

        .customization-panel {
            background: var(--secondary);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .panel-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }

        .panel-header i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .panel-title {
            font-size: 1.4rem;
            color: var(--text);
        }

        .customization-section {
            margin-bottom: 25px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: var(--text);
        }

        .section-title i {
            color: var(--primary);
        }

        .color-picker {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .color-option {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: var(--transition);
        }

        .color-option:hover {
            transform: scale(1.1);
        }

        .color-option.active {
            border-color: var(--text);
            transform: scale(1.1);
        }

        .font-options,
        .style-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .font-option,
        .style-option {
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }

        .font-option:hover,
        .style-option:hover {
            background: var(--form-bg);
        }

        .font-option.active,
        .style-option.active {
            background: var(--primary);
            color: var(--text-light);
            border-color: var(--primary);
        }

        .roboto {
            font-family: 'Roboto', sans-serif;
        }

        .poppins {
            font-family: 'Poppins', sans-serif;
        }

        .opensans {
            font-family: 'Open Sans', sans-serif;
        }

        .montserrat {
            font-family: 'Montserrat', sans-serif;
        }

        .reset-btn {
            width: 100%;
            padding: 12px;
            background: var(--form-bg);
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            color: var(--text);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .reset-btn:hover {
            background: var(--accent);
            color: var(--text-light);
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 25px;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: none;
            font-size: 1rem;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary), var(--highlight));
            color: var(--text-light);
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .btn-secondary {
            background: var(--secondary);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--form-bg);
        }

        .save-btn {
            background: var(--success);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            justify-content: center;
            width: 100%;
            margin-bottom: 15px;
        }

        .save-btn:hover {
            background: var(--accent);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: white;
        }

        .template-sidebar-container {
            background: var(--secondary);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow);
        }

        .template-sidebar-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .template-sidebar-title {
            font-size: 1.4rem;
            color: var(--text);
        }

        .template-grid-layout {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .template-card-item {
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
        }

        .template-card-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .template-card-item.active-template {
            border: 2px solid var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 128, 128, 0.2);
        }

        .template-preview-container {
            width: auto;
            height: 300px;
            background: var(--form-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border);
            overflow: hidden;
        }

        .template-preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .template-card-item:hover .template-preview-image {
            transform: scale(1.05);
        }

        .template-details {
            padding: 15px;
            position: relative;
        }

        .template-name {
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: var(--text);
        }

        .template-description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
        }

        .template-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .template-tag {
            background: var(--form-bg);
            padding: 5px 10px;
            border-radius: 30px;
            font-size: 0.8rem;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 0.9rem;
        }

        /* Badge for selected template */
        .template-badge-current {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--primary);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            z-index: 10;
        }

        /* Edit link styling */
        .edit-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            padding: 12px 25px;
            border: 1px solid var(--primary);
            border-radius: var(--border-radius);
        }

        .edit-link:hover {
            background: var(--primary);
            color: var(--text-light);
        }

        /* Success and error messages */
        .message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            z-index: 1000;
            animation: slideInRight 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .success-message {
            background: var(--success);
            color: white;
        }

        .info-message {
            background: #3498db;
            color: white;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* View mode styles */
        body.view-mode .left-panel,
        body.view-mode .right-panel {
            display: none;
        }

        body.view-mode .resume-container {
            max-width: 100%;
            margin: 0 auto;
        }

        body.view-mode .main-container {
            justify-content: center;
        }

        /* Resume Score Styles */
        .resume-score-card {
            background: var(--secondary);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .score-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .score-header i {
            font-size: 1.8rem;
            color: var(--primary);
        }

        .score-title {
            font-size: 1.4rem;
            color: var(--text);
        }

        .score-display {
            text-align: center;
            margin-bottom: 25px;
        }

        .score-circle {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 15px;
        }

        .score-progress {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: conic-gradient(var(--score-color) <?php echo $resumeScore['percentage'] * 3.6; ?>deg, var(--border) 0deg);
            position: relative;
        }

        .score-progress::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            background: var(--secondary);
            border-radius: 50%;
        }

        .score-value {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            font-weight: 700;
            color: var(--score-color);
        }

        .score-text {
            font-size: 1.1rem;
            color: var(--text);
            margin-bottom: 5px;
        }

        .score-feedback {
            font-size: 0.9rem;
            color: #666;
        }

        .score-breakdown {
            margin-top: 20px;
        }

        .breakdown-title {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .breakdown-title i {
            color: var(--primary);
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .breakdown-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .breakdown-category {
            font-size: 0.9rem;
            color: var(--text);
            text-transform: capitalize;
        }

        .breakdown-score {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text);
        }

        .breakdown-feedback {
            width: 100%;
            font-size: 0.8rem;
            color: #666;
            margin-top: 5px;
        }

        .improve-btn {
            width: 100%;
            padding: 12px;
            background: var(--form-bg);
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            color: var(--text);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            text-decoration: none;
        }

        .improve-btn:hover {
            background: var(--accent);
            color: var(--text-light);
        }

        @media (max-width: 1200px) {
            .main-container {
                flex-direction: column;
            }

            .left-panel,
            .right-panel {
                width: 100%;
            }

            .template-grid-layout {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .template-grid-layout {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .template-grid-layout {
                grid-template-columns: 1fr;
            }

            .main-container {
                gap: 20px;
            }

            .left-panel {
                order: 2;
            }

            .resume-container {
                order: 1;
            }

            .right-panel {
                order: 3;
            }

            .toggle-view-btn {
                position: relative;
                top: 0;
                right: 0;
                margin: 10px auto;
                display: inline-flex;
            }
        }

        /* Template-specific styles */
        #template-content {
            width: 100%;
            height: 100%;
            /* Initialize CSS variables for the template */
            --primary-color: #008080;
            --accent-color: #006666;
            --highlight-color: #00A3A3;
            --font-family: 'Poppins', sans-serif;
        }

        /* Template style classes */
        .modern-style {
            --border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 128, 128, 0.1);
        }

        .classic-style {
            --border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            --primary-color: #2c3e50;
            --accent-color: #34495e;
            --highlight-color: #7f8c8d;
        }

        .bold-style {
            --border-radius: 8px;
            box-shadow: 0 10px 30px rgba(211, 84, 0, 0.2);
            --primary-color: #d35400;
            --accent-color: #e67e22;
            --highlight-color: #f39c12;
        }

        .minimal-style {
            --border-radius: 0;
            box-shadow: none;
            --primary-color: #333;
            --accent-color: #555;
            --highlight-color: #777;
            border: 1px solid var(--border);
        }

        /* Loading indicator */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-content {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: var(--shadow-hover);
        }

        .loading-spinner {
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* FIXED PRINT STYLES - This is the key fix for header printing */
        @media print {

            /* Force color printing for headers */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            @page {
                margin: 0.5in;
                size: A4;
            }

            /* Hide everything that shouldn't be printed */
            body>*:not(.container) {
                display: none !important;
            }

            .container>*:not(.main-container) {
                display: none !important;
            }

            .main-container>*:not(.resume-container) {
                display: none !important;
            }

            /* Reset body for clean printing */
            body {
                background: white !important;
                font-size: 12pt;
                line-height: 1.4;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .main-container {
                display: block !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Style the resume container for printing */
            .resume-container {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                background: white !important;
                overflow: visible !important;
                page-break-inside: avoid;
            }

            /* Ensure template content prints properly */
            #template-content {
                width: 100% !important;
                height: auto !important;
                position: static !important;
                margin: 0 !important;
                padding: 15pt !important;
                background: white !important;
                overflow: visible !important;
            }

            /* CRITICAL: Preserve header styling for print */
            #template-content .header {
                background: var(--primary-color, #008080) !important;
                color: white !important;
                padding: 20pt !important;
                margin: 0 0 15pt 0 !important;
                page-break-inside: avoid;
                print-color-adjust: exact !important;
                -webkit-print-color-adjust: exact !important;
            }

            /* Ensure all header elements are styled properly */
            #template-content .header,
            #template-content .header *,
            #template-content .header .profile-image,
            #template-content .header .name,
            #template-content .header .title,
            #template-content .header .contact-info,
            #template-content .header .contact-item,
            #template-content .header .contact-item *,
            #template-content .header h1,
            #template-content .header h2,
            #template-content .header h3,
            #template-content .header p,
            #template-content .header span,
            #template-content .header div,
            #template-content .header i {
                color: white !important;
                background: transparent !important;
                print-color-adjust: exact !important;
                -webkit-print-color-adjust: exact !important;
            }

            /* Ensure header divider is visible */
            #template-content .header .divider {
                background: white !important;
                height: 2pt !important;
                margin: 10pt 0 !important;
                border: none !important;
                print-color-adjust: exact !important;
                -webkit-print-color-adjust: exact !important;
            }

            /* Style other sections appropriately */
            #template-content .section-title,
            #template-content h2:not(.header h2),
            #template-content h3:not(.header h3) {
                color: var(--primary-color, #008080) !important;
                border-bottom: 2px solid var(--primary-color, #008080) !important;
                font-weight: bold !important;
                margin: 15pt 0 8pt 0 !important;
                padding-bottom: 4pt !important;
                page-break-after: avoid;
                print-color-adjust: exact !important;
                -webkit-print-color-adjust: exact !important;
            }

            /* Regular content styling */
            #template-content p:not(.header p),
            #template-content li,
            #template-content span:not(.header span) {
                color: black !important;
                font-size: 11pt;
                line-height: 1.4;
                margin-bottom: 6pt;
            }

            /* Company names and important text */
            #template-content .company,
            #template-content .institution,
            #template-content .job-title,
            #template-content .degree {
                color: var(--primary-color, #008080) !important;
                font-weight: bold !important;
                print-color-adjust: exact !important;
                -webkit-print-color-adjust: exact !important;
            }

            /* Dates and secondary info */
            #template-content .date,
            #template-content .duration {
                color: #666 !important;
                font-style: italic;
                font-size: 10pt;
            }

            /* Remove animations and transitions */
            #template-content *,
            #template-content *::before,
            #template-content *::after {
                animation: none !important;
                transition: none !important;
                transform: none !important;
                box-shadow: none !important;
            }

            /* Handle page breaks properly */
            #template-content .section,
            #template-content .experience-item,
            #template-content .education-item {
                page-break-inside: avoid;
                margin-bottom: 12pt;
            }

            /* Links in print */
            #template-content a {
                color: inherit !important;
                text-decoration: none !important;
            }

            /* Skills and progress bars - convert to text for print */
            #template-content .skill-bar {
                display: none !important;
            }

            /* Lists formatting */
            #template-content ul {
                margin-left: 15pt;
                margin-bottom: 8pt;
            }

            #template-content li {
                margin-bottom: 4pt;
            }
        }
    </style>
</head>

<body>
    <?php if (isset($save_success) && $save_success): ?>
        <div class="message success-message" id="success-message">
            <i class="fas fa-check-circle"></i> Template saved to history successfully!
        </div>
    <?php endif; ?>

    <?php if (isset($already_saved) && $already_saved): ?>
        <div class="message info-message" id="info-message">
            <i class="fas fa-info-circle"></i> This template is already in your history!
        </div>
    <?php endif; ?>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <span>Loading template...</span>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1><?php echo htmlspecialchars($resume['full_name'] ?? 'My Resume'); ?></h1>
            <p>Preview your professional resume</p>
            <button class="toggle-view-btn" id="toggle-view-btn">
                <i class="fas fa-eye"></i> View Resume
            </button>
        </div>

        <div class="main-container">
            <!-- Left Panel - Customization -->
            <div class="left-panel">
                <!-- Resume Score Card -->
                <div class="resume-score-card">
                    <div class="score-header">
                        <i class="fas fa-chart-line"></i>
                        <h3 class="score-title">Resume Score</h3>
                    </div>

                    <div class="score-display">
                        <div class="score-circle">
                            <div class="score-progress" style="--score-color: 
                            <?php
                            if ($resumeScore['percentage'] >= 80) echo '#27ae60';
                            elseif ($resumeScore['percentage'] >= 60) echo '#f39c12';
                            else echo '#e74c3c';
                            ?>;"></div>
                            <div class="score-value"><?php echo $resumeScore['percentage']; ?>%</div>
                        </div>
                        <div class="score-text">
                            <?php
                            if ($resumeScore['percentage'] >= 80) echo 'Excellent Resume!';
                            elseif ($resumeScore['percentage'] >= 60) echo 'Good Resume';
                            elseif ($resumeScore['percentage'] >= 40) echo 'Average Resume';
                            else echo 'Needs Improvement';
                            ?>
                        </div>
                        <div class="score-feedback">
                            <?php echo $resumeScore['total']; ?> out of <?php echo $resumeScore['max']; ?> points
                        </div>
                    </div>

                    <div class="score-breakdown">
                        <h4 class="breakdown-title">
                            <i class="fas fa-list-ul"></i>
                            Score Breakdown
                        </h4>

                        <?php foreach ($resumeScore['details'] as $category => $detail): ?>
                            <div class="breakdown-item">
                                <div>
                                    <div class="breakdown-category">
                                        <?php
                                        echo ucfirst(str_replace('_', ' ', $category));
                                        ?>
                                    </div>
                                    <div class="breakdown-feedback">
                                        <?php echo $detail['feedback']; ?>
                                    </div>
                                </div>
                                <div class="breakdown-score">
                                    <?php echo $detail['score']; ?>/<?php echo $detail['max']; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <a href="updateForm.php?resume_id=<?php echo $user_id; ?>" class="improve-btn">
                        <i class="fas fa-magic"></i> Improve My Resume
                    </a>
                </div>

                <div class="customization-panel">
                    <div class="panel-header">
                        <i class="fas fa-sliders-h"></i>
                        <h3 class="panel-title">Customize Template</h3>
                    </div>

                    <!-- Color Customization -->
                    <div class="customization-section">
                        <h4 class="section-title">
                            <i class="fas fa-palette"></i>
                            Color Scheme
                        </h4>
                        <div class="color-picker">
                            <div class="color-option active" style="background: #008080;" data-primary="#008080" data-accent="#006666" data-highlight="#00A3A3"></div>
                            <div class="color-option" style="background: #2c3e50;" data-primary="#2c3e50" data-accent="#34495e" data-highlight="#3498db"></div>
                            <div class="color-option" style="background: #3498db;" data-primary="#3498db" data-accent="#2980b9" data-highlight="#2ecc71"></div>
                            <div class="color-option" style="background: #e74c3c;" data-primary="#e74c3c" data-accent="#c0392b" data-highlight="#f39c12"></div>
                            <div class="color-option" style="background: #27ae60;" data-primary="#27ae60" data-accent="#219653" data-highlight="#2d9cdb"></div>
                            <div class="color-option" style="background: #9b59b6;" data-primary="#9b59b6" data-accent="#8e44ad" data-highlight="#3498db"></div>
                        </div>
                    </div>

                    <!-- Font Customization -->
                    <div class="customization-section">
                        <h4 class="section-title">
                            <i class="fas fa-font"></i>
                            Font Family
                        </h4>
                        <div class="font-options">
                            <div class="font-option poppins active" data-font="Poppins, sans-serif">Poppins</div>
                            <div class="font-option roboto" data-font="Roboto, sans-serif">Roboto</div>
                            <div class="font-option opensans" data-font="Open Sans, sans-serif">Open Sans</div>
                            <div class="font-option montserrat" data-font="Montserrat, sans-serif">Montserrat</div>
                        </div>
                    </div>

                    <!-- Style Customization -->
                    <div class="customization-section">
                        <h4 class="section-title">
                            <i class="fas fa-brush"></i>
                            Style Options
                        </h4>
                        <div class="style-options">
                            <div class="style-option active" data-style="modern">Modern</div>
                            <div class="style-option" data-style="classic">Classic</div>
                            <div class="style-option" data-style="bold">Bold</div>
                            <div class="style-option" data-style="minimal">Minimal</div>
                        </div>
                    </div>

                    <button class="reset-btn" id="reset-customization">
                        <i class="fas fa-undo"></i> Reset to Default
                    </button>

                    <!-- Save to History Button -->
                    <a href="preview.php?resume_id=<?php echo $user_id; ?>&template=<?php echo $selected_template; ?>&action=save" class="save-btn" id="save-btn">
                        <i class="fas fa-save"></i> Save to History
                    </a>

                    <a href="updateForm.php?resume_id=<?php echo $user_id; ?>" class="edit-link" id="edit-link">
                        <i class="fas fa-edit"></i> Edit Resume Content
                    </a>

                    <div class="action-buttons">
                        <a href="generate_pdf.php?resume_id=<?php echo $user_id; ?>&template=<?php echo $selected_template; ?>"
                            class="btn btn-primary" id="download-btn">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
                        <a href="dashboard.php" class="btn btn-secondary" id="history-btn">
                            <i class="fas fa-history"></i> View History
                        </a>
                    </div>
                </div>
            </div>

            <!-- Center - Resume Container -->
            <div class="resume-container" id="resume-container">
                <div id="template-content" class="template-wrapper">
                    <?php include "temp/{$selected_template}.php"; ?>
                </div>
            </div>

            <!-- Right Panel - Template Suggestions -->
            <div class="right-panel">
                <div class="template-sidebar-container">
                    <div class="template-sidebar-header">
                        <i class="fas fa-palette"></i>
                        <h3 class="template-sidebar-title">Choose Template Style</h3>
                    </div>

                    <div class="template-grid-layout">
                        <?php
                        $templates = [
                            'template1',
                            'template2',
                            'template3',
                            'template4',
                            'template5',
                            'template6',
                            'template7',
                            'template8',
                            'template9',
                            'template10',
                            'template11',
                            'template12',
                            'template13',
                            'template14',
                            'template15'
                        ];
                        foreach ($templates as $template) {
                            $info = getTemplateInfo($template);
                            $isActive = ($template === $selected_template) ? 'active-template' : '';
                        ?>
                            <div class="template-card-item <?php echo $isActive; ?>" data-template="<?php echo $template; ?>">
                                <?php if ($template === $selected_template) { ?>
                                    <div class="template-badge-current">Selected</div>
                                <?php } ?>
                                <div class="template-preview-container">
                                    <img src="assets/images/templates/<?php echo $info['image']; ?>"
                                        alt="<?php echo $info['name']; ?> Template"
                                        class="template-preview-image">
                                </div>
                                <div class="template-details">
                                    <h4 class="template-name"><?php echo $info['name']; ?></h4>
                                    <p class="template-description"><?php echo $info['description']; ?></p>
                                    <div class="template-tags">
                                        <?php foreach ($info['tags'] as $tag) { ?>
                                            <span class="template-tag"><?php echo $tag; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        const userId = <?php echo $user_id; ?>;
        const currentTemplate = '<?php echo $selected_template; ?>';
        const templateContent = document.getElementById('template-content');
        const loadingOverlay = document.getElementById('loading-overlay');
        const toggleViewBtn = document.getElementById('toggle-view-btn');
        let isViewMode = false;

        // Toggle view mode
        function toggleViewMode() {
            isViewMode = !isViewMode;

            if (isViewMode) {
                document.body.classList.add('view-mode');
                toggleViewBtn.innerHTML = '<i class="fas fa-edit"></i> Edit';
                toggleViewBtn.setAttribute('title', 'Exit view mode to edit template');
            } else {
                document.body.classList.remove('view-mode');
                toggleViewBtn.innerHTML = '<i class="fas fa-eye"></i> View Resume';
                toggleViewBtn.setAttribute('title', 'View resume without side panels');
            }

            // Save view mode preference
            localStorage.setItem('resumeViewMode', isViewMode);
        }

        // Initialize template with default styles
        function initializeTemplate() {
            templateContent.style.setProperty('--primary-color', '#008080');
            templateContent.style.setProperty('--accent-color', '#006666');
            templateContent.style.setProperty('--highlight-color', '#00A3A3');
            templateContent.style.fontFamily = 'Poppins, sans-serif';
            templateContent.classList.add('modern-style');
        }

        // Show/Hide loading overlay
        function showLoading() {
            loadingOverlay.style.display = 'flex';
        }

        function hideLoading() {
            loadingOverlay.style.display = 'none';
        }

        // Hide success/info messages after 4 seconds
        function hideMessages() {
            const successMessage = document.getElementById('success-message');
            const infoMessage = document.getElementById('info-message');

            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.animation = 'slideInRight 0.3s ease reverse';
                    setTimeout(() => successMessage.remove(), 300);
                }, 4000);
            }

            if (infoMessage) {
                setTimeout(() => {
                    infoMessage.style.animation = 'slideInRight 0.3s ease reverse';
                    setTimeout(() => infoMessage.remove(), 300);
                }, 4000);
            }
        }

        // Change color scheme
        function changeColorScheme(primary, accent, highlight) {
            templateContent.style.setProperty('--primary-color', primary);
            templateContent.style.setProperty('--accent-color', accent);
            templateContent.style.setProperty('--highlight-color', highlight);

            // Save to localStorage
            localStorage.setItem('resumePrimaryColor', primary);
            localStorage.setItem('resumeAccentColor', accent);
            localStorage.setItem('resumeHighlightColor', highlight);
        }

        // Change font family
        function changeFontFamily(font) {
            templateContent.style.fontFamily = font;
            localStorage.setItem('resumeFontFamily', font);
        }

        // Change style
        function changeStyle(style) {
            // Remove all style classes first
            templateContent.classList.remove('modern-style', 'classic-style', 'bold-style', 'minimal-style');
            // Add the selected style class
            templateContent.classList.add(`${style}-style`);
            localStorage.setItem('resumeStyle', style);
        }

        // Reset customization
        function resetCustomization() {
            // Reset to default values
            changeColorScheme('#008080', '#006666', '#00A3A3');
            changeFontFamily('Poppins, sans-serif');
            changeStyle('modern');

            // Update UI active states
            updateActiveStates();

            // Clear localStorage
            localStorage.removeItem('resumePrimaryColor');
            localStorage.removeItem('resumeAccentColor');
            localStorage.removeItem('resumeHighlightColor');
            localStorage.removeItem('resumeFontFamily');
            localStorage.removeItem('resumeStyle');
        }

        // Update active states in UI
        function updateActiveStates() {
            const primaryColor = localStorage.getItem('resumePrimaryColor') || '#008080';
            const fontFamily = localStorage.getItem('resumeFontFamily') || 'Poppins, sans-serif';
            const style = localStorage.getItem('resumeStyle') || 'modern';

            // Update color options
            document.querySelectorAll('.color-option').forEach(option => {
                const optionColor = option.getAttribute('data-primary');
                option.classList.toggle('active', optionColor === primaryColor);
            });

            // Update font options
            document.querySelectorAll('.font-option').forEach(option => {
                const optionFont = option.getAttribute('data-font');
                option.classList.toggle('active', optionFont === fontFamily);
            });

            // Update style options
            document.querySelectorAll('.style-option').forEach(option => {
                const optionStyle = option.getAttribute('data-style');
                option.classList.toggle('active', optionStyle === style);
            });
        }

        // Load saved preferences
        function loadPreferences() {
            const primaryColor = localStorage.getItem('resumePrimaryColor');
            const accentColor = localStorage.getItem('resumeAccentColor');
            const highlightColor = localStorage.getItem('resumeHighlightColor');

            if (primaryColor && accentColor && highlightColor) {
                changeColorScheme(primaryColor, accentColor, highlightColor);
            }

            const fontFamily = localStorage.getItem('resumeFontFamily');
            if (fontFamily) {
                changeFontFamily(fontFamily);
            }

            const style = localStorage.getItem('resumeStyle');
            if (style) {
                changeStyle(style);
            }

            // Load view mode preference
            const savedViewMode = localStorage.getItem('resumeViewMode');
            if (savedViewMode === 'true') {
                toggleViewMode();
            }

            updateActiveStates();
        }

        // Change template function - with smooth navigation
        function changeTemplate(templateName) {
            if (templateName === currentTemplate) return;

            showLoading();

            // Add a small delay to show the loading animation
            setTimeout(() => {
                window.location.href = `preview.php?resume_id=${userId}&template=${templateName}`;
            }, 500);
        }

        // Download as PDF
        function downloadPDF() {
            window.open(`generate_pdf.php?resume_id=${userId}&template=${currentTemplate}`, '_blank');
        }

        // Update score colors based on percentage
        function updateScoreColor(percentage) {
            let color;
            if (percentage >= 80) color = '#27ae60';
            else if (percentage >= 60) color = '#f39c12';
            else color = '#e74c3c';

            document.querySelector('.score-progress').style.setProperty('--score-color', color);
            document.querySelector('.score-value').style.color = color;
        }

        // Set up all event listeners
        function setupEventListeners() {
            // Toggle view button
            toggleViewBtn.addEventListener('click', toggleViewMode);

            // Color options
            document.querySelectorAll('.color-option').forEach(option => {
                option.addEventListener('click', function() {
                    const primary = this.getAttribute('data-primary');
                    const accent = this.getAttribute('data-accent');
                    const highlight = this.getAttribute('data-highlight');
                    changeColorScheme(primary, accent, highlight);

                    document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Font options
            document.querySelectorAll('.font-option').forEach(option => {
                option.addEventListener('click', function() {
                    const font = this.getAttribute('data-font');
                    changeFontFamily(font);

                    document.querySelectorAll('.font-option').forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Style options
            document.querySelectorAll('.style-option').forEach(option => {
                option.addEventListener('click', function() {
                    const style = this.getAttribute('data-style');
                    changeStyle(style);

                    document.querySelectorAll('.style-option').forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Reset button
            document.getElementById('reset-customization').addEventListener('click', resetCustomization);

            // Template selection
            document.querySelectorAll('.template-card-item').forEach(item => {
                item.addEventListener('click', function() {
                    const templateName = this.getAttribute('data-template');
                    if (templateName !== currentTemplate) {
                        // Add visual feedback
                        this.style.opacity = '0.7';
                        changeTemplate(templateName);
                    }
                });

                // Add hover effects
                item.addEventListener('mouseenter', function() {
                    if (this.getAttribute('data-template') !== currentTemplate) {
                        this.style.transform = 'translateY(-8px) scale(1.02)';
                    }
                });

                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + P for print
                if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                    e.preventDefault();
                    window.print();
                }

                // Ctrl/Cmd + E for edit
                if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                    e.preventDefault();
                    window.location.href = 'updateForm.php?resume_id=' + userId;
                }

                // Ctrl/Cmd + S for save to history
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    window.location.href = `preview.php?resume_id=${userId}&template=${currentTemplate}&action=save`;
                }

                // ESC to close loading overlay
                if (e.key === 'Escape') {
                    hideLoading();
                }

                // V to toggle view mode
                if (e.key === 'v' || e.key === 'V') {
                    e.preventDefault();
                    toggleViewMode();
                }

                // D to download PDF
                if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                    e.preventDefault();
                    downloadPDF();
                }
            });
        }

        // Auto-save customization changes
        let saveTimeout;

        function autoSaveCustomization() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                console.log('Auto-saving customization preferences...');
                // You can implement an AJAX call here to save customization to database
            }, 2000);
        }

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize template
            initializeTemplate();

            // Load saved preferences
            loadPreferences();

            // Setup all event listeners
            setupEventListeners();

            // Hide messages after delay
            hideMessages();

            // Hide loading overlay in case it's showing
            hideLoading();

            // Initialize score color
            const score = <?php echo $resumeScore['percentage']; ?>;
            updateScoreColor(score);

            console.log('Resume preview initialized successfully');
            console.log('Resume Score: <?php echo $resumeScore["percentage"]; ?>%');
        });

        // Handle page visibility changes
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Page is hidden (user switched tabs)
                hideLoading();
            } else {
                // Page is visible again
                console.log('Page is visible again');
            }
        });

        // Handle errors gracefully
        window.addEventListener('error', function(e) {
            console.error('JavaScript error:', e.error);
            hideLoading();
        });

        // Prevent form submission on Enter key in customization options
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && e.target.classList.contains('color-option', 'font-option', 'style-option')) {
                e.preventDefault();
                e.target.click();
            }
        });
    </script>
</body>

</html>