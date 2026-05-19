CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titulo` VARCHAR(255) NOT NULL,
  `descricao` VARCHAR(150) NOT NULL,
  `corpo` LONGTEXT NOT NULL,
  `imagem` VARCHAR(255) DEFAULT NULL,
  `categoria` INT,
  `autor` VARCHAR(100),
  `data_criacao` DATETIME,
  `usuario_id` INT,
  CONSTRAINT `fk_autor` FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios`(`id`) 
    ON DELETE SET NULL 
);