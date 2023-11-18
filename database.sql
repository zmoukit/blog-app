
--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_post_id` int(11) DEFAULT NULL,
  `comment_user_id` int(11) DEFAULT NULL,
  `comment_created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comment_post_id` (`comment_post_id`),
  KEY `comment_user_id` (`comment_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(255) NOT NULL,
  `post_image_url` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_published_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `post_author_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  KEY `post_author_id` (`post_author_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_title`, `post_image_url`, `post_content`, `post_published_at`, `post_author_id`) VALUES
(1, 'Check24', 'https://placehold.co/600x400', 'Check24 is a well-known German comparison website that allows users to compare a wide range of products and services, including insurance, financial products, travel bookings, energy providers, and more. It provides a platform for users to compare prices, features, and details of different options to make informed decisions.', '2023-11-07 12:02:01', 1),
(2, 'Check24', 'https://placehold.co/600x400', 'Check24 is a well-known German comparison website that allows users to compare a wide range of products and services, including insurance, financial products, travel bookings, energy providers, and more. It provides a platform for users to compare prices, features, and details of different options to make informed decisions.', '2023-11-07 12:02:01', 1),
(3, 'Power BI', 'https://placehold.co/400', 'Response\r\nPower BI, short for \"Power Business Intelligence,\" is a business analytics tool developed by Microsoft. It allows users to visualize and share insights from their data in a more user-friendly and interactive manner. Here are some key points about Power BI:', '2023-11-07 12:03:13', 1),
(4, 'Power BI', 'https://placehold.co/400', 'Response\r\nPower BI, short for \"Power Business Intelligence,\" is a business analytics tool developed by Microsoft. It allows users to visualize and share insights from their data in a more user-friendly and interactive manner. Here are some key points about Power BI:', '2023-11-07 12:03:13', 1),
(5, 'The Power and Versatility of PHP', 'https://placehold.jp/200x200.png', 'Introduction:\r\nPHP, which stands for \"PHP: Hypertext Preprocessor,\" is a widely-used server-side scripting language that has played a significant role in web development since its creation in 1994. Known for its power and versatility, PHP has become a cornerstone of modern web applications and websites. In this post, we\'ll explore some key aspects of PHP and why it continues to be a top choice for web developers worldwide.\r\n\r\n1. Server-Side Scripting:\r\nPHP is primarily a server-side scripting language. This means that the PHP code is executed on the server, and the server sends the resulting HTML to the client\'s browser. This allows for dynamic web pages and applications, as PHP can interact with databases, process forms, and generate content in real-time.\r\n\r\n2. Open Source and Free:\r\nOne of the most significant advantages of PHP is its open-source nature. It\'s completely free to use and has a vibrant community of developers contributing to its growth and improvement. This open-source nature has led to a wealth of libraries, frameworks, and tools, making it easier for developers to build complex web applications.\r\n\r\n3. Easy to Learn:\r\nPHP is known for its relatively low learning curve, making it accessible to developers of all skill levels. If you\'re just starting with web development, PHP is an excellent language to begin with. The syntax is straightforward, and there are plenty of online resources and tutorials available.\r\n\r\n4. Versatile and Cross-Platform:\r\nPHP is a cross-platform language, meaning it can run on various operating systems. Whether you\'re hosting your application on Linux, Windows, or macOS, PHP can adapt. It\'s also compatible with different web servers like Apache, Nginx, and more.\r\n\r\n5. Strong Database Integration:\r\nPHP seamlessly integrates with popular databases such as MySQL, PostgreSQL, and SQLite, allowing developers to create powerful database-driven web applications. Its compatibility with databases is a key reason why PHP remains a top choice for building content management systems (CMS) like WordPress.\r\n\r\n6. Huge Community and Documentation:\r\nPHP boasts a massive and active community of developers. This community ensures that the language remains up-to-date and supported. There\'s a wealth of documentation and resources available, making it easy to troubleshoot issues and find solutions to common challenges.\r\n\r\n7. Web Security:\r\nPHP provides built-in features to help enhance web security, such as input validation, authentication mechanisms, and protection against common security vulnerabilities. However, developers need to be vigilant and follow best practices to ensure the security of their applications.\r\n\r\nConclusion:\r\nPHP has stood the test of time and continues to be a preferred choice for web developers worldwide. Its versatility, ease of use, and strong community support make it an excellent language for developing everything from simple web pages to complex web applications. As the web development landscape evolves, PHP remains a relevant and powerful tool in the hands of creative developers. If you\'re looking to start a career in web development or want to build a dynamic website, PHP is a solid choice worth considering.', '2023-11-07 12:41:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password_hash` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL,
  `lastLogin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_mobile` (`mobile`),
  UNIQUE KEY `uq_email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `mobile`, `email`, `password_hash`, `created_at`, `lastLogin`) VALUES
(1, 'Zakaria', 'Moukit', '0670812760', 'zmoukit233@gmail.com', 'password', '2023-11-07 12:08:33', NULL);
COMMIT;
