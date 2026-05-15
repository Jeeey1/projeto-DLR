CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titulo` VARCHAR(255) NOT NULL,
  `corpo` LONGTEXT NOT NULL,
  `imagem` VARCHAR(255) DEFAULT NULL,
  `tag` VARCHAR(100),
  'autor' VARCHAR(100),
  `data_criacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` INT,
  CONSTRAINT `fk_autor` FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios`(`id`) 
    ON DELETE SET NULL 
);