DROP TRIGGER IF EXISTS crear_usuario;
DELIMITER $$
CREATE TRIGGER crear_usuario AFTER INSERT ON usuario 
	FOR EACH ROW
		BEGIN 
			INSERT INTO cliente SET id_usuario = NEW.id;
		END$$
DELIMITER ;
