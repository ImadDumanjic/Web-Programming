let Constants = {
  //PROJECT_BASE_URL: "http://localhost/project/backend/",
  PROJECT_BASE_URL:
    location.hostname === "localhost"
      ? "http://localhost:83/project/backend/"
      : "https://luxury-drive-2w37n.ondigitalocean.app/index.php/",
  CUSTOMER_ROLE: "Customer", 
  ADMIN_ROLE: "Admin"
};