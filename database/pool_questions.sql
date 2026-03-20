CREATE TABLE IF NOT EXISTS `pool_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 1,
  `correct_answer` enum('yes','no') DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_pool_questions_pool_id` (`pool_id`),
  KEY `idx_pool_questions_position` (`position`),
  CONSTRAINT `fk_pool_questions_pool_id` FOREIGN KEY (`pool_id`) REFERENCES `pools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `pool_question_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) NOT NULL,
  `pool_question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `answer` enum('yes','no') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_pool_user_question` (`pool_id`, `pool_question_id`, `user_id`),
  KEY `idx_pool_question_answers_user` (`user_id`),
  CONSTRAINT `fk_pool_question_answers_pool_id` FOREIGN KEY (`pool_id`) REFERENCES `pools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pool_question_answers_question_id` FOREIGN KEY (`pool_question_id`) REFERENCES `pool_questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pool_question_answers_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
