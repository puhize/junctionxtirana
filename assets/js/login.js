const signUpButton = document.getElementById("signUp");
const signInButton = document.getElementById("signIn");
const container = document.getElementById("container");
const errorMessageSignUp = document.getElementById("errorMessageSignUp");
signUpButton.addEventListener("click", () => {
  // if (errorMessageSignUp.style.display !== "block") {
  container.classList.add("right-panel-active");
});
// });

signInButton.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});
