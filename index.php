<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Derya Portfolio</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <header class="header">
    <nav class="navbar">
      <h2 class="logo">Derya Özdemir<span>.</span></h2>

<ul class="nav-links">
  <li><a href="#home">Home</a></li>
  <li><a href="#about">About</a></li>
  <li><a href="#skills">Skills</a></li>
  <li><a href="#projects">Projects</a></li>
  <li><a href="#contact">Contact</a></li>
  <li><a href="#education">Education</a></li>
  <li><a href="admin/login.php">Admin</a></li>
</ul>

      <button id="themeBtn" class="theme-btn">🌙</button>
    </nav>
  </header>

  <main>
    <section id="home" class="hero">
      <div class="hero-content">
        <p class="small-title">Hello, I'm</p>

        <h1>Derya Özdemir</h1>

        <h3>
          Software Engineering Student <br>
          & Full-Stack Developer
        </h3>

        <p>
          I am a third-year Software Engineering student at Haliç University.
          I am interested in full-stack web development, database systems,
          backend development and modern user-friendly web applications.
        </p>

        <div class="hero-buttons">
          <a href="#projects" class="btn primary-btn">View Projects</a>
          <a href="#contact" class="btn secondary-btn">Contact Me</a>
        </div>
      </div>

<div class="hero-visual">

  <div class="code-window">

    <div class="window-top">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <div class="code-content">
      <p><span class="code-blue">const</span> developer = {</p>

      <p>&nbsp;&nbsp;name:
        <span class="code-green">"Derya Özdemir"</span>,
      </p>

      <p>&nbsp;&nbsp;role:
        <span class="code-green">
          "Software Engineering Student"
        </span>,
      </p>

      <p>&nbsp;&nbsp;skills:
        [
        <span class="code-green">"PHP"</span>,
        <span class="code-green">"JavaScript"</span>,
        <span class="code-green">"MySQL"</span>
        ]
      </p>

      <p>};</p>
    </div>

  </div>

</div>
    </section>

<section id="about" class="section">
  <h2 class="section-title">About Me</h2>

  <div class="about-card">

    <div class="about-text">
      <p>
        I am Derya Özdemir, a third-year Software Engineering student at Haliç University.
        I focus on backend development, database systems and full-stack web applications.
        I enjoy building modern, dynamic and user-friendly software projects while continuously improving my technical skills.
      </p>

      <div class="about-buttons">

        <a href="https://github.com/deryyazdmr"
           target="_blank"
           class="btn secondary-btn">
          <i class="fa-brands fa-github"></i>
          GitHub
        </a>

        <a href="https://www.linkedin.com/feed/"
           target="_blank"
           class="btn secondary-btn">
          <i class="fa-brands fa-linkedin"></i>
          LinkedIn
        </a>

        <a href="assets/cv/Derya-CV.pdf"
           target="_blank"
           class="btn primary-btn">
          <i class="fa-solid fa-file"></i>
          View CV
        </a>

      </div>
    </div>

  </div>
</section>

    <section id="skills" class="section">
      <h2 class="section-title">Skills</h2>

<div class="skills-grid">
  <div class="skill-card"><i class="fa-solid fa-code"></i><span>C#</span></div>
  <div class="skill-card"><i class="fa-brands fa-microsoft"></i><span>ASP.NET MVC</span></div>
  <div class="skill-card"><i class="fa-solid fa-database"></i><span>SQL Server</span></div>
  <div class="skill-card"><i class="fa-solid fa-layer-group"></i><span>Entity Framework</span></div>
  <div class="skill-card"><i class="fa-brands fa-html5"></i><span>HTML5</span></div>
  <div class="skill-card"><i class="fa-brands fa-css3-alt"></i><span>CSS3</span></div>
  <div class="skill-card"><i class="fa-brands fa-js"></i><span>JavaScript</span></div>
  <div class="skill-card"><i class="fa-brands fa-php"></i><span>PHP</span></div>
  <div class="skill-card"><i class="fa-solid fa-database"></i><span>MySQL</span></div>
  <div class="skill-card"><i class="fa-brands fa-python"></i><span>Python</span></div>
  <div class="skill-card"><i class="fa-brands fa-java"></i><span>Java</span></div>
  <div class="skill-card"><i class="fa-solid fa-code"></i><span>C++</span></div>
</div>
    </section>

    <section id="projects" class="section">
      <h2 class="section-title">Projects</h2>

      <div id="projectsContainer" class="projects-grid"></div>
    </section>

<section id="education" class="section">
  <h2 class="section-title">Education & Certificates</h2>

  <div class="education-card">

    <div class="education-column">
      <h3>Education</h3>

      <p>
        <strong>Haliç University</strong><br>
        Faculty of Engineering<br>
        Software Engineering Department<br>
        2022 - 2027
      </p>
    </div>

    <div class="education-column">
      <h3>Certificates</h3>

      <ul class="certificate-list">
        <li>Web Programming Training</li>
        <li>C# Training</li>
        <li>SQL Server Database Expertise</li>
        <li>E-Government Approved Software Expertise</li>
      </ul>
    </div>

  </div>
</section>

    <section id="experience" class="section">
      <h2 class="section-title">Experience</h2>

      <div class="project-card">
        <h3>Software Intern - RecRam Software</h3>

        <p>
          During my internship, I worked on web application development,
          form structures, database processes and backend development.
        </p>
      </div>
    </section>
        <section id="contact" class="section">
      <h2 class="section-title">Contact Me</h2>

      <form id="contactForm" class="contact-form" action="#" method="POST">
        <input type="text" id="name" name="name" placeholder="Your Name" />
        <input type="email" id="email" name="email" placeholder="Your Email" />
        <input type="text" id="subject" name="subject" placeholder="Subject" />
        <textarea id="message" name="message" placeholder="Your Message"></textarea>

        <button type="submit" class="btn primary-btn">Send Message</button>

        <p id="formMessage"></p>
      </form>
    </section>
  </main>

  <footer class="footer">
    <p>© 2026 Derya Portfolio. All rights reserved.</p>
  </footer>

  <script src="assets/js/app.js"></script>
</body>
</html>