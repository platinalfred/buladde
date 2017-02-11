
drop procedure if exists calc_exceeded_days;
delimiter $$
create procedure calc_exceeded_days(IN loans_id INT, IN loan_date DATE, IN cur_date date, IN loan_duration INT, IN exp_payback DECIMAL(12,2), OUT no_days INT)
    begin
        SELECT DATEDIFF(cur_date, DATE_ADD(loan_date, INTERVAL  TIMESTAMPDIFF(MONTH,loan_date,cur_date) MONTH)) INTO no_days
		FROM `loan_repayment` `lp`
		WHERE
		### (`transaction_date` BETWEEN DATE_ADD(loan_date, INTERVAL  TIMESTAMPDIFF(MONTH,loan_date,cur_date) MONTH) AND DATE_ADD(loan_date, INTERVAL TIMESTAMPDIFF(MONTH,loan_date,cur_date)+1 MONTH)) AND
		`lp`.`loan_id` = loans_id AND
		###Check if the amount paid before is, less than the total amount that should have been paid by the next scheduled payment date AND
		(SELECT COALESCE(SUM(`amount`),0) FROM `loan_repayment` WHERE `transaction_date`<=cur_date)< ((exp_payback/loan_duration)*TIMESTAMPDIFF(MONTH,loan_date,cur_date)+1);
    end $$
delimiter ;


###function to call the above procedure to be returned to a caller in a statement
DROP FUNCTION IF EXISTS get_default_days;

DELIMITER $$

CREATE FUNCTION get_default_days(loan_id INT, loan_date DATE, loan_end_date DATE, cur_date DATE, exp_payback DECIMAL(12,2))
	RETURNS INT
BEGIN
	DECLARE temp_days, no_days, loan_duration, loan_age INT DEFAULT 0;
    DECLARE tempDate DATE;
	SET loan_duration = TIMESTAMPDIFF(MONTH,loan_date,loan_end_date);
	SET loan_age = TIMESTAMPDIFF(MONTH,loan_date,cur_date);
	IF loan_age >0 THEN
	WHILE (loan_age > 0) DO
		SET loan_age = loan_age-1;
		SET tempDate = DATE_SUB(cur_date, INTERVAL loan_age MONTH);
		CALL exceeded_days(loan_id, loan_date, cur_date, loan_duration, exp_payback, loan_age,temp_days);
		SET no_days = no_days + temp_days;
	END WHILE;
    END IF;
	
	RETURN COALESCE(no_days,0);
END$$

DELIMITER ;