<?php

session_set_cookie_params(3600);
session_start();

include_once("settings.php");
include_once("functions.php");
include_once("db-conn.php");
include_once("create-table.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Index">
	<meta name="keywords" content="Home, index">
	<meta name="author" content="Palida Parichayawong">

	<title>Home</title>

	<!-- References to external CSS files -->
	<link href="styles/style.css" rel="stylesheet">
</head>
<!-- This is a comment. Indenting child elements makes the markup much more readable -->
<body class="body-bg">

	<?php include_once("header.inc"); ?>

	<div class="container-fluid">
		<div class="row">
			<div class="col">
				
				
				<h1>CorpU</h1>

				<article>
					<h2>Overview: </h2>
					
					<p>CorpU is an esteemed IT university dedicated to providing comprehensive education and professional development opportunities for individuals pursuing careers in the ever-evolving field of information technology. With a focus on cutting-edge technology, hands-on learning experiences, and industry-relevant curriculum, CorpU stands at the forefront of IT education.</p>
					
					<h2>Campus and Facilities:</h2>

					<p>Located in a vibrant tech hub, CorpU boasts a state-of-the-art campus equipped with advanced laboratories, collaborative spaces, and cutting-edge infrastructure. The campus provides an immersive learning environment that fosters creativity, innovation, and critical thinking.</p>
					
					<h2>Academic Programs:</h2>
					<p>CorpU offers a diverse range of IT programs designed to equip students with the knowledge, skills, and competencies necessary to thrive in the digital age. The university offers undergraduate and graduate programs, including:</p>
					<ul>
						<li>Bachelor of Science in Computer Science: This program provides a strong foundation in computer science principles, software development, algorithms, and data structures. Students gain hands-on experience through practical projects and have the opportunity to specialize in areas such as artificial intelligence, cybersecurity, or software engineering.</li>
						<li>Master of Science in Information Technology: This advanced program caters to IT professionals seeking to enhance their expertise and leadership capabilities. It covers emerging technologies, IT strategy, project management, and data analytics, enabling graduates to tackle complex IT challenges in various industries.</li>
						<li>Diploma in Network Administration: This program focuses on developing networking expertise, including network design, administration, troubleshooting, and security. Students gain practical skills through extensive lab sessions and real-world simulations, preparing them for successful careers as network administrators or engineers.</li>
					</ul>

					<h2>Career Services and Industry Partnerships:</h2>
					<p>
					CorpU understands the importance of practical experience and industry connections in launching successful IT careers. The university maintains strong relationships with leading tech companies, facilitating internships, cooperative education programs, and job placement opportunities for its students. Additionally, career development services such as resume workshops, mock interviews, and networking events are offered to support students in their professional growth.
					</p>
				</article>
			</div>
		</div>
	</div>
	
	<?php include_once("footer.inc"); ?>

</body>
</html>
