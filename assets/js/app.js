
const contactForm = document.getElementById("contactForm");
const formMessage = document.getElementById("formMessage");
const projectsContainer = document.getElementById("projectsContainer");

themeBtn.addEventListener("click", () => {
  document.body.classList.toggle("light-mode");
  themeBtn.textContent = document.body.classList.contains("light-mode")
    ? "☀️"
    : "🌙";
});

async function loadProjects() {
  try {
    const response = await fetch("api/projects.php");
    const data = await response.json();

    projectsContainer.innerHTML = "";

    data.projects.forEach((project) => {
      const card = document.createElement("div");

      card.className = "project-card";

      card.innerHTML = `
        <h3>${project.title}</h3>
        <p>${project.description}</p>
        <span class="project-tech">${project.technologies}</span>
      `;

      projectsContainer.appendChild(card);
    });

  } catch (error) {
    console.log(error);
  }
}

loadProjects();

contactForm.addEventListener("submit", function (e) {
  e.preventDefault();

  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const subject = document.getElementById("subject").value.trim();
  const message = document.getElementById("message").value.trim();

  formMessage.className = "";

  if (name === "" || email === "" || subject === "" || message === "") {
    formMessage.textContent = "Please fill in all fields.";
    formMessage.classList.add("message-error");
    return;
  }

  if (!email.includes("@") || !email.includes(".")) {
    formMessage.textContent = "Please enter a valid email address.";
    formMessage.classList.add("message-error");
    return;
  }

  if (message.length < 10) {
    formMessage.textContent = "Message must be at least 10 characters.";
    formMessage.classList.add("message-error");
    return;
  }

  formMessage.textContent = "Form validation successful!";
  formMessage.classList.add("message-success");
});