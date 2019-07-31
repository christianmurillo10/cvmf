SET FOREIGN_KEY_CHECKS = 0;

-- EMPLOYEES
TRUNCATE `employees`;
TRUNCATE `employee_contacts`;
TRUNCATE `employee_educational_backgrounds`;
TRUNCATE `employee_government_details`;
TRUNCATE `employee_images`;
TRUNCATE `employee_references`;
TRUNCATE `employee_relatives`;

-- EMPLOYEES CONTRACTS
TRUNCATE `employee_contracts`;
TRUNCATE `employee_salaries`;
TRUNCATE `employee_benefits`;

-- TRIPS
TRUNCATE `trip_billing_details`;
TRUNCATE `trip_billing_headers`;
TRUNCATE `trip_credit_balance`;
TRUNCATE `trip_demurrages`;
TRUNCATE `trip_expenses`;
TRUNCATE `trip_foul_trips`;
TRUNCATE `trip_partitions`;
TRUNCATE `trip_payment_details`;
TRUNCATE `trip_payment_headers`;
TRUNCATE `trip_personnels`;
TRUNCATE `trip_transactions`;
TRUNCATE `trips`;

SET FOREIGN_KEY_CHECKS = 1;