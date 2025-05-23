/*begin::Theme mode setup on page load*/
var defaultThemeMode = "dark";
var themeMode;
if (document.documentElement) {
      if (document.documentElement.hasAttribute("data-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-theme-mode");
      } else {
            if (localStorage.getItem("data-theme") !== null) {
                  themeMode = localStorage.getItem("data-theme");
            } else {
                  themeMode = defaultThemeMode;
            }
      }
      if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
      }
      document.documentElement.setAttribute("data-theme", themeMode);
}
/*end::Theme mode setup on page load*/