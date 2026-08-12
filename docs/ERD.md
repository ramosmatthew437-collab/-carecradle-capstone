# CareCradle ERD

users
------
id
name
email
password
role
is_active

↓

mothers
--------
id
user_id
mother_code
first_name
middle_name
last_name
birth_date
contact_number
address
barangay
blood_type
civil_status
occupation
philhealth_number
height
weight
last_menstrual_period
expected_delivery_date
pregnancy_number
status

↓

prenatal_checkups

↓

appointments

↓

infants

↓

medical_logs

↓

sms_notifications