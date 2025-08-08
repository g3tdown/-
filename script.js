const buttons = document.querySelectorAll("nav button");
const pages = document.querySelectorAll(".page");

buttons.forEach(button => {
  button.addEventListener("click", () => {
    buttons.forEach(btn => btn.classList.remove("active"));
    pages.forEach(page => page.classList.remove("active"));

    button.classList.add("active");
    const pageId = button.dataset.page;
    document.getElementById(pageId).classList.add("active");
  });
});
