TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`about_us`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`banners`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`clients`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`company_infos`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`contacts`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`email_configs`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`events`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`locations`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`management`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`market_concentrations`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`menu_items`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`portfolios`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`products`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`resource_infos`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`testimonials`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`failed_jobs`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`password_resets`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`personal_access_tokens`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`users`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`audits`;
TRUNCATE table `YOUR_PROD_DATABASE_NAME`.`migrations`;
SET SQL_SAFE_UPDATES = 0;
DELETE FROM `YOUR_PROD_DATABASE_NAME`.`client_categories`;
DELETE FROM `YOUR_PROD_DATABASE_NAME`.`portfolio_categories`;
DELETE FROM `YOUR_PROD_DATABASE_NAME`.`menus`;
DELETE FROM `YOUR_PROD_DATABASE_NAME`.`pages`;
SET SQL_SAFE_UPDATES = 1;
