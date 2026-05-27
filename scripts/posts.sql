-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/05/2026 às 00:48
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `super_ego`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(150) DEFAULT NULL,
  `corpo` longtext NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `categoria` int(100) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `autor` varchar(255) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `titulo`, `descricao`, `corpo`, `imagem`, `categoria`, `data_criacao`, `autor`, `usuario_id`) VALUES
(6, 'O que a Avaliação Neuropsicológica revela sobre a sua mente?', 'Muito além de um teste de memória, a avaliação neuropsicológica é um mapa detalhado de como o seu cérebro processa o mundo.', '<p>A mente humana é um universo complexo, e muitas vezes, os sintomas que experimentamos no dia a dia — como esquecimentos frequentes, dificuldade de concentração ou alterações bruscas de humor — são apenas a ponta do iceberg. É aqui que entra a avaliação neuropsicológica.</p><p><br></p><h2><strong>O que é, afinal?</strong> </h2><p>Diferente de uma sessão de psicoterapia tradicional, a avaliação neuropsicológica é um processo investigativo estruturado. Utilizando testes padronizados, validados cientificamente, buscamos mapear as funções cognitivas do paciente: atenção, memória, linguagem, raciocínio executivo e habilidades visuoespaciais.</p><p><br></p><p><strong>Quando ela é indicada?</strong> Geralmente, médicos (neurologistas, psiquiatras) ou o próprio paciente buscam essa avaliação em casos de:</p><ul><li>Suspeita de TDAH (Transtorno de Déficit de Atenção e Hiperatividade) em adultos ou crianças.</li><li>Investigação de quadros de demência (como o Alzheimer) em idosos.</li><li>Dificuldades de aprendizagem não explicadas.</li><li>Mudanças comportamentais após traumas cranianos ou acidentes vasculares.</li></ul><p><br></p><p>Compreender o funcionamento exato do seu cérebro não serve apenas para \"dar um nome\" ao problema através de um diagnóstico, mas principalmente para traçar um plano de reabilitação eficiente, devolvendo a autonomia e a qualidade de vida.</p>', 'src/img/posts/img_6a0e543e48b6f.png', 8, '2026-05-21 03:00:00', 'Daniel', 1),
(7, 'Burnout ou Cansaço? Aprendendo a ler os sinais do esgotamento', 'Quando o fim de semana não é mais suficiente para recarregar as energias, o seu corpo pode estar sinalizando algo mais grave.', '<p>Vivemos em uma sociedade que frequentemente romantiza a exaustão. \"Trabalhe enquanto eles dormem\" é um lema perigoso que tem levado milhares de profissionais ao colapso físico e mental, conhecido clinicamente como Síndrome de Burnout.</p><p><br></p><h2><strong>A diferença entre o cansaço e o esgotamento</strong></h2><p><br></p><p> O cansaço comum é fisiológico. Após uma semana difícil, uma boa noite de sono ou um fim de semana de descanso são suficientes para que você se sinta revigorado. O Burnout, por outro lado, é um esgotamento crônico. O descanso perde o seu efeito reparador. Você acorda exausto e a simples ideia de abrir a caixa de e-mails ou iniciar o expediente gera sintomas físicos, como taquicardia, sudorese ou problemas gastrointestinais.</p><p><br></p><p><strong>Os três pilares do Burnout:</strong></p><ol><li><strong>Exaustão emocional profunda:</strong> Uma sensação de \"bateria zerada\" que não passa.</li><li><strong>Despersonalização:</strong> Começar a tratar colegas, clientes ou pacientes com cinismo, frieza ou irritabilidade injustificada.</li><li><strong>Baixa realização profissional:</strong> O sentimento de que o seu trabalho não tem valor ou de que você é incompetente, mesmo com um histórico de sucesso.</li></ol><p><br></p><p>Ignorar esses sinais é permitir que o corpo tome a decisão de parar por você. A psicoterapia oferece um espaço seguro para recalcular a rota, estabelecer limites saudáveis e ressignificar a sua relação com a produtividade e o tempo.</p>', 'src/img/posts/img_6a0e54accf1f0.jpg', 10, '2026-05-21 03:00:00', 'Daniel', 1),
(8, 'O silêncio na terapia: Por que às vezes não sabemos o que dizer?', 'O silêncio durante a sessão não é um espaço vazio ou constrangedor, mas sim um momento repleto de elaborações profundas.', '<p>Muitas pessoas chegam à primeira sessão de terapia com uma ansiedade comum: <em>\"Doutor, e se eu não tiver o que falar? E se der um branco?\"</em>. Existe um mito de que o paciente precisa preencher todos os minutos do atendimento com relatos detalhados e organizados.</p><p><br></p><p>Na prática clínica, especialmente com uma escuta analítica, o silêncio é tão importante quanto a palavra falada.</p><p><br></p><h2><strong>O que o silêncio comunica?</strong></h2><p><br></p><p> Quando o paciente se cala, algo está acontecendo internamente. Esse silêncio pode ter diversas naturezas:</p><ul><li><strong>Silêncio de elaboração:</strong> Aquele momento após um insight doloroso ou libertador, onde a mente precisa de alguns minutos para processar a nova percepção.</li><li><strong>Silêncio de resistência:</strong> Quando a conversa se aproxima de um trauma ou de um assunto muito difícil, e o psiquismo, na tentativa de se proteger, \"desliga\" o fluxo de palavras.</li><li><strong>Silêncio de descanso:</strong> A permissão para simplesmente estar ali, na presença de outro ser humano que acolhe sem julgar, sem a obrigação social de \"render assunto\".</li></ul><p><br></p><p>Um bom profissional não se apressa em preencher o vazio com perguntas aleatórias. O terapeuta sustenta esse silêncio junto com o paciente, ajudando-o a investigar, no seu próprio tempo, o que mora naquelas pausas. Não tenha medo das suas pausas. Elas falam muito sobre você.</p>', 'src/img/posts/img_6a0e54f029d1a.jpg', 5, '2026-05-21 03:00:00', 'Daniel', 1),
(9, 'teste', 'teste', '<p>teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets teste teste ets </p>', 'src/img/posts/img_6a0e5c978e1c6.png', 14, '2026-05-21 03:00:00', 'Daniel', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_autor` (`usuario_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_autor` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
