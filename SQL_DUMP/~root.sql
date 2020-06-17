CREATE TABLE `contacts` (
  `id` mediumint(9) NOT NULL,
  `email` char(60) COLLATE utf8_unicode_ci NOT NULL,
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_ip` char(60) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `fish_cats` (
  `id` mediumint(9) NOT NULL,
  `cat_name` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `cat_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cat_button_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `fish_cats` (`id`, `cat_name`, `cat_class`, `cat_button_class`, `cat_id`) VALUES
(1, 'Сладководни', '', 'btn-info', 1),
(2, 'Соленоводни', 'list-group-item-success', 'btn-success', 2);

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `id` mediumint(9) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_added` int(11) NOT NULL,
  `title` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `fish_cat` int(11) NOT NULL,
  `description` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `photo_url` char(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` mediumint(9) NOT NULL,
  `username` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` char(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time_registered` int(11) NOT NULL,
  `website` char(60) COLLATE utf8_unicode_ci NOT NULL,
  `user_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `public_info` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_gsm` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fish_cats`
--
ALTER TABLE `fish_cats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
