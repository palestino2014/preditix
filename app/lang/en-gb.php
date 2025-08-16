<?php
/**
 * English (United Kingdom) Translations
 * Work Order Management System - Preditix
 */

return [
    // General
    'app_name' => 'Preditix OS Manager',
    'welcome' => 'Welcome',
    'login' => 'Login',
    'logout' => 'Logout',
    'user' => 'User',
    'password' => 'Password',
    'email' => 'Email',
    'name' => 'Name',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'view' => 'View',
    'back' => 'Back',
    'next' => 'Next',
    'previous' => 'Previous',
    'finish' => 'Finish',
    'confirm' => 'Confirm',
    'yes' => 'Yes',
    'no' => 'No',
    'ok' => 'OK',
    'loading' => 'Loading...',
    'success' => 'Success',
    'error' => 'Error',
    'warning' => 'Warning',
    'info' => 'Information',
    
    // Authentication
    'login_title' => 'System Access',
    'login_button' => 'Sign In',
    'invalid_credentials' => 'Invalid username or password',
    'logout_success' => 'You have successfully logged out',
    'session_expired' => 'Your session has expired. Please log in again.',
    
    // Users
    'user_type_tecnico' => 'Technician',
    'user_type_gestor' => 'Manager',
    
    // Dashboard
    'dashboard_title' => 'Work Orders',
    'open_os' => 'Open WO',
    'total_os' => 'Total WOs',
    'pending_approval' => 'Pending Approval',
    
    // Filters
    'filter' => 'Filters',
    'filter_options' => 'Filter Options',
    'all_status' => 'All Status',
    'authorization' => 'Authorization',
    'all_authorizations' => 'All Authorizations',
    'authorized' => 'Authorized',
    'pending_authorization' => 'Pending Authorization',
    'technician' => 'Technician',
    'all_technicians' => 'All Technicians',
    'asset' => 'Asset',
    'all_assets' => 'All Assets',
    'clear_filters' => 'Clear Filters',
    
    // Work Order
    'os_number' => 'WO No.',
    'vehicle_tag' => 'Vehicle Tag',
    'maintenance_type' => 'Maintenance Type',
    'priority' => 'Priority',
    'status' => 'Status',
    'manager' => 'Manager',
    'responsible' => 'Responsible',
    'opening_date' => 'Opening Date',
    'approval_date' => 'Approval Date',
    'completion_date' => 'Completion Date',
    'cancellation_date' => 'Cancellation Date',
    'observations' => 'Observations',
    
    // Maintenance Types
    'maintenance_preventiva' => 'Preventive',
    'maintenance_corretiva' => 'Corrective',
    'maintenance_preditiva' => 'Predictive',
    
    // Priorities
    'priority_baixa' => 'Low',
    'priority_media' => 'Medium',
    'priority_alta' => 'High',
    'priority_critica' => 'Critical',
    
    // Status
    'status_aberta' => 'Open',
    'status_em_andamento' => 'In Progress',
    'status_editada' => 'Edited',
    'status_concluida' => 'Completed',
    'status_cancelada' => 'Cancelled',
    'status_rejeitada' => 'Rejected',
    
    // Actions
    'approve' => 'Approve',
    'reject' => 'Reject',
    'complete' => 'Complete',
    'reopen_as_new' => 'Reopen as New',
    'reopening_os_description' => 'Reopening an existing work order with the same data. You can modify the fields as needed.',
    'try_again' => 'Try Again',
    'give_up' => 'Give Up',
    
    // Affected Systems
    'affected_systems' => 'Affected Systems',
    'system_cabine' => 'Cabin',
    'system_direcao' => 'Steering',
    'system_combustivel' => 'Fuel',
    'system_medicao_controle' => 'Measurement & Control',
    'system_protecao_impactos' => 'Impact Protection',
    'system_transmissao' => 'Transmission',
    'system_estrutural' => 'Structural',
    'system_acoplamento' => 'Coupling',
    'system_controle_eletronico' => 'Electronic Control',
    'system_exaustao' => 'Exhaust',
    'system_propulsao' => 'Propulsion',
    'system_protecao_incendio' => 'Fire Protection',
    'system_ventilacao' => 'Ventilation',
    'system_tanque' => 'Tank',
    'system_arrefecimento' => 'Cooling',
    'system_descarga' => 'Discharge',
    'system_freios' => 'Brakes',
    'system_protecao_ambiental' => 'Environmental Protection',
    'system_suspensao' => 'Suspension',
    'system_eletrico' => 'Electrical',
    
    // Detected Symptoms
    'detected_symptoms' => 'Detected Symptoms',
    'symptom_aberto' => 'Open',
    'symptom_sujo' => 'Dirty',
    'symptom_desvio_lateral' => 'Lateral Deviation',
    'symptom_queimado' => 'Burnt',
    'symptom_sem_freio' => 'No Brake',
    'symptom_vazando' => 'Leaking',
    'symptom_baixo_rendimento' => 'Low Performance',
    'symptom_empenado' => 'Warped',
    'symptom_rompido' => 'Broken',
    'symptom_sem_velocidade' => 'No Speed',
    'symptom_travado' => 'Stuck',
    'symptom_vibrando' => 'Vibrating',
    'symptom_desarmado' => 'Disarmed',
    'symptom_ruido_anormal' => 'Abnormal Noise',
    'symptom_solto' => 'Loose',
    'symptom_trincando' => 'Cracking',
    
    // Items
    'items' => 'Items',
    'item_description' => 'Description',
    'quantity' => 'Quantity',
    'unit_value' => 'Unit Value',
    'total' => 'Total',
    'add_item' => 'Add Item',
    'remove_item' => 'Remove Item',
    
    // Form Pagination
    'page_info' => 'Page %d of %d',
    'step_basic_info' => 'Basic Information',
    'step_affected_systems' => 'Affected Systems',
    'step_symptoms' => 'Detected Symptoms',
    'step_causes' => 'Defect Causes',
    'step_interventions' => 'Interventions Performed',
    'step_actions' => 'Actions Performed',
    'step_observations' => 'Observations',
    'step_items' => 'Items',
    
    // Success Messages
    'os_created_success' => 'Work Order created successfully.',
    'os_created_pending' => 'Work Order created successfully.\nSubject to approval.',
    'os_approved_success' => 'Work Order approved successfully.',
    'os_rejected_success' => 'Work Order rejected successfully.',
    
    // Confirmation Messages
    'confirm_cancel_form' => 'Are you sure you want to cancel? All data will be lost.',
    'confirm_cancel_os' => 'Are you sure you want to cancel the creation of this Work Order? All data will be lost.',
    'confirm_cancel_active_os' => 'Are you sure you want to cancel this Work Order in progress?',
    'confirm_approve' => 'Are you sure you want to approve this action?',
    'confirm_reject' => 'Are you sure you want to reject this action?',
    
    // Rejection Modal
    'reject_title' => 'Reject %s',
    'reject_reason' => 'Why are you rejecting?',
    'reject_reason_required' => 'Rejection reason is required.',
    'speak' => 'Speak',
    'type' => 'Type',
    
    // Vehicle
    'vehicle' => 'Vehicle',
    'select_vehicle' => 'Select a vehicle',
    'select_maintenance_type' => 'Select type',
    'maintenance_preventiva' => 'Preventive',
    'maintenance_corretiva' => 'Corrective',
    'maintenance_preditiva' => 'Predictive',
    'select_priority' => 'Select priority',
    'priority_baixa' => 'Low',
    'priority_media' => 'Medium',
    'priority_alta' => 'High',
    'priority_critica' => 'Critical',
    'select_manager' => 'Select manager',
    'initial_observations' => 'Initial observations',
    'describe_problem' => 'Describe the problem or situation observed...',
    'voice_input' => 'Voice input',
    'create_os' => 'Create WO',
    'fill_required_fields' => 'Fill all required fields',
    'fill_basic_info' => 'Fill in the basic Work Order information',
    'tag' => 'Tag',
    'model' => 'Model',
    'color' => 'Colour',
    'plate' => 'Plate',
    
    // Offline
    'offline_mode' => 'Offline Mode',
    'sync_pending' => 'Sync Pending',
    'sync_success' => 'Data synced successfully',
    'sync_error' => 'Sync error',
    
    // Notifications
    'notification_os_approved' => 'Your WO #%d was approved',
    'notification_os_rejected' => 'Your WO #%d was rejected',
    'notification_os_pending' => 'New WO #%d needs approval',
    
    // Errors
    'error_database' => 'Database connection error',
    'error_permission' => 'You do not have permission for this action',
    'error_not_found' => 'Record not found',
    'error_validation' => 'Invalid data',
    'error_unknown' => 'Unknown error',
];