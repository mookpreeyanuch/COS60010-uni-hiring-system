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
	<meta name="description" content="Jobs">
	<meta name="keywords" content="Jobs, Jobs description">
	<meta name="author" content="Palida Parichayawong">

	<title>Jobs</title>

	<!-- References to external CSS files -->
	<link href="styles/style.css" rel="stylesheet">
</head>
<body>

	<?php include_once("header.inc"); ?>

	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<h1>Jobs</h1>

				<section class="section-card">
					<div class="row">
						<div class="col-12 col-sm-9">
							<h2>IT Instructor</h2>
							<small>Reference number: <strong>ICT01</strong></small>
							<hr>

							<h3>Job Description</h3>

							<p>CorpU is seeking a dynamic and experienced IT Instructor to join our esteemed faculty. The ideal candidate will have a passion for teaching and a deep understanding of IT concepts and technologies. As an IT Instructor, you will play a key role in shaping the future of IT professionals by delivering high-quality instruction, engaging students, and fostering a stimulating learning environment.</p>
						
							<h3>Key responsibilities include:</h3>
							
							<ul>
								<li>Deliver engaging and interactive lectures and lab sessions on various IT subjects, ensuring students comprehend and apply key concepts effectively.</li>
								<li>Develop and update course materials, including syllabi, lesson plans, assignments, and assessments, in alignment with program objectives and industry standards.</li>
								<li>Facilitate discussions, group activities, and hands-on exercises to promote active learning and critical thinking among students.</li>
								<li>Provide individualized support and guidance to students, addressing their questions, concerns, and academic needs.</li>
								<li>Assess student performance through assignments, exams, and projects, providing timely and constructive feedback for continuous improvement.</li>
								<li>Stay up-to-date with the latest advancements in IT, industry trends, and best practices, incorporating relevant updates into instructional materials and methodologies.</li>
								<li>Collaborate with colleagues to enhance curriculum design, develop new programs, and participate in faculty meetings and professional development activities.</li>
								<li>Contribute to the university's research initiatives, industry partnerships, and community engagement efforts.
							</ul>
							
							<h3>Qualifications</h3>
						
							<ul>
								<li>A master's degree or higher in Computer Science, Information Technology, or a related field. Relevant industry certifications (e.g., CCNA, CompTIA, CISSP) are a plus.</li>
								<li>Minimum of 3 years of teaching or training experience in the IT field, preferably at the higher education level.</li>
								<li>Excellent communication and presentation skills, with the ability to convey complex IT concepts in a clear and understandable manner.</li>
								<li>Demonstrated ability to engage and inspire students, fostering a positive and inclusive learning environment.</li>
								<li>Proficiency in using instructional technologies, learning management systems, and multimedia tools to enhance teaching and learning experiences.</li>
								<li>Strong organizational skills, attention to detail, and the ability to meet deadlines and manage multiple priorities effectively.</li>
								experiences.</li>
								<li>A passion for staying abreast of emerging technologies and industry trends, and a commitment to continuous professional development.</li>
								<li>Experience in research, publications, or involvement in IT-related projects is desirable.</li>
							</ul>
				
							<p>CorpU is an equal opportunity employer. We welcome applicants from all backgrounds and encourage diversity and inclusion in our workforce.</p>
				
							

							<div class="mb-2">
								<a href="apply.php?jobref=ICT01" class="btn btn-primary">Apply</a>
								<!-- <a href="https://www.seek.com.au/job/66416426?type=standout#sol=d7a697cbe3b4533b366dc39ee538018229ea0d0f" class="btn btn-light" target="_blank">Reference</a> -->
							</div>
						</div>

						<aside class="col-12 col-sm-3">
							<p><strong>Salary range:</strong> 120-150K</p>
							<p><strong>Faculty/Department:</strong> Computer Science and Software Engineering</p>
						</aside>
					</div>
				</section>

				<section class="section-card">
					<div class="row">
						<div class="col-12 col-sm-9">
							<h2>Learning Experience Designer</h2>
							<small>Reference number: <strong>ICT02</strong></small>
							<hr>

							<h3>Job Description</h3>

							<p>
							CorpU is seeking a talented and creative Learning Experience Designer to join our team. The Learning Experience Designer will play a crucial role in designing and developing engaging and effective learning experiences for our students. The ideal candidate should have a strong background in instructional design, a passion for technology, and a drive to create impactful learning solutions.
							</p>

							<h3>Responsibilities</h3>

							<ul>
								<li>Collaborate with subject matter experts and stakeholders to analyze learning needs, goals, and objectives, and translate them into effective learning solutions.</li>
								<li>Design and develop engaging and interactive learning experiences, including online courses, multimedia materials, simulations, assessments, and other learning resources.</li>
								<li>Apply instructional design principles and best practices to create learner-centered experiences that promote knowledge retention and application.</li>
								<li>Utilize a variety of instructional strategies, technologies, and multimedia tools to enhance learning outcomes and engagement.</li>
								<li>Conduct needs assessments, gather learner feedback, and evaluate the effectiveness of learning solutions to drive continuous improvement.</li>
								<li>Ensure learning content is accurate, up-to-date, and aligned with industry trends and standards.</li>
								<li>Collaborate with instructional designers, multimedia specialists, and developers to create and deliver high-quality learning experiences.</li>
								<li>Stay current with emerging trends, technologies, and methodologies in instructional design and e-learning, and proactively apply them to enhance learning solutions.</li>
								<li>Participate in cross-functional projects, contribute to the development of new programs, and provide expertise in instructional design and learning experience development.</li>
								<li>Maintain project documentation, timelines, and deliverables to ensure smooth execution of learning design projects.</li>

							</ul>
							
							<h3>Qualifications</h3>
				
							<ul>
								<li>Bachelor's degree in Instructional Design, Educational Technology, or a related field. Master's degree is a plus.</li>
								<li>Minimum of 3 years of experience in instructional design, learning experience design, or a similar role, preferably in an educational or corporate training setting.</li>
								<li>Strong knowledge of instructional design principles, adult learning theories, and e-learning methodologies.</li>
								<li>Proficiency in using e-learning authoring tools (e.g., Articulate Storyline, Adobe Captivate) and learning management systems.</li>
								<li>Experience with multimedia tools, graphic design, video editing, and animation software is highly desirable.</li>
								<li>Strong project management skills, with the ability to manage multiple projects and meet deadlines.</li>
								<li>Excellent written and verbal communication skills, with the ability to effectively present complex ideas and concepts.</li>
								<li>Strong problem-solving and analytical skills, with a detail-oriented mindset.</li>
								<li>Self-motivated, adaptable, and able to work both independently and collaboratively in a team environment.</li>
								<li>A passion for technology, learning innovation, and creating impactful learning experiences.</li>
								
							</ul>

							

							<div class="mb-2">
								<a href="apply.php?jobref=ICT02" class="btn btn-primary">Apply</a>
								<!-- <a href="https://www.linkedin.com/jobs/collections/recommended/?currentJobId=3526523417" class="btn btn-light" target="_blank">Reference</a> -->
							</div>
						</div>

						<aside class="col-12 col-sm-3">
							<p><strong>Salary range:</strong> 100-130K</p>
							<p><strong>Faculty/Department:</strong> Computer Design and Animation</p>
						</aside>
					</div>
				</section>
			</div>
		</div>
	</div>

	<?php include_once("footer.inc"); ?>

</body>
</html>
