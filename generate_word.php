<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date_of_birth = $_POST['date_of_birth'];
    $patient_id = $_POST['patient_id'];
    $family_history = $_POST['family_history'];
    $past_medical_history = $_POST['past_medical_history'];
    $current_medications = $_POST['current_medications'];
    $prenatal_symptoms = !empty($_POST['prenatal_symptoms']) ? implode(', ', $_POST['prenatal_symptoms']) : '';
    $newborn_symptoms = !empty($_POST['newborn_symptoms']) ? implode(', ', $_POST['newborn_symptoms']) : '';
    $childhood_symptoms = !empty($_POST['childhood_symptoms']) ? implode(', ', $_POST['childhood_symptoms']) : '';
    $adolescent_symptoms = !empty($_POST['adolescent_symptoms']) ? implode(', ', $_POST['adolescent_symptoms']) : '';
    $genetic_testing = $_POST['genetic_testing'];
    $cardiac_evaluation = $_POST['cardiac_evaluation'];
    $renal_evaluation = $_POST['renal_evaluation'];
    $growth_hormone = $_POST['growth_hormone'];
    $cardiac_treatment = $_POST['cardiac_treatment'];
    $hearing_management = $_POST['hearing_management'];
    $renal_treatment = $_POST['renal_treatment'];
    $ovarian_failure_management = $_POST['ovarian_failure_management'];
    $bone_health = $_POST['bone_health'];
    $specialist_consultations = $_POST['specialist_consultations'];
    $follow_up_plan = $_POST['follow_up_plan'];

    require_once 'vendor/autoload.php';
    
    use PhpOffice\PhpWord\PhpWord;
    use PhpOffice\PhpWord\IOFactory;

    $phpWord = new PhpWord();

    $section = $phpWord->addSection();
    $section->addTitle('Dossier Médical - Syndrome de Turner', 1);

    $section->addTitle('Informations Personnelles', 2);
    $section->addText("Nom: $name");
    $section->addText("Date de Naissance: $date_of_birth");
    $section->addText("ID du Patient: $patient_id");

    $section->addTitle('Historique Médical', 2);
    $section->addText("Antécédents Familiaux: $family_history");
    $section->addText("Antécédents Médicaux Personnels: $past_medical_history");
    $section->addText("Médicaments Actuels: $current_medications");

    $section->addTitle('Symptômes et Signes Cliniques', 2);
    $section->addText("Symptômes Prénataux: $prenatal_symptoms");
    $section->addText("Symptômes chez le Nouveau-né: $newborn_symptoms");
    $section->addText("Symptômes de l'Enfance: $childhood_symptoms");
    $section->addText("Symptômes à l'Adolescence: $adolescent_symptoms");

    $section->addTitle('Évaluations et Diagnostics', 2);
    $section->addText("Tests Génétiques: $genetic_testing");
    $section->addText("Évaluation Cardiaque: $cardiac_evaluation");
    $section->addText("Évaluation Rénale: $renal_evaluation");

    $section->addTitle('Gestion et Traitement', 2);
    $section->addText("Thérapie par Hormone de Croissance: $growth_hormone");
    $section->addText("Traitement Cardiaque: $cardiac_treatment");
    $section->addText("Gestion de l'Audition: $hearing_management");
    $section->addText("Traitement Rénal: $renal_treatment");
    $section->addText("Gestion de l'Insuffisance Ovarienne: $ovarian_failure_management");
    $section->addText("Santé Osseuse: $bone_health");

    $section->addTitle('Consultations et Suivis', 2);
    $section->addText("Consultations Spécialistes: $specialist_consultations");
    $section->addText("Plan de Suivi: $follow_up_plan");

    $filename = "dossier_medical_{$patient_id}.docx";
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($filename);

    header("Content-Description: File Transfer");
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    flush();
    readfile($filename);
    unlink($filename);
    exit;
}
?>
