let Constants = {
  //PROJECT_BASE_URL: "http://localhost/project/backend/",
  PROJECT_BASE_URL:
    location.hostname === "localhost"
      ? "http://localhost/project/backend/"
      : "https://luxury-drive-2w37n.ondigitalocean.app/",
  CUSTOMER_ROLE: "Customer", 
  ADMIN_ROLE: "Admin"
};