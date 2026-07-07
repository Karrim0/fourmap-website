/**
 * FourMap Admin Dashboard - JavaScript
 */

// Toggle Sidebar (Mobile)
function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebarOverlay");

  if (sidebar && overlay) {
    sidebar.classList.toggle("active");
    overlay.classList.toggle("active");
  }
}

// Image Preview Function
function previewImage(event) {
  const reader = new FileReader();
  const file = event.target.files[0];

  if (file) {
    reader.onload = function (e) {
      const preview = document.getElementById("imagePreview");
      const container = document.getElementById("imagePreviewContainer");

      if (preview && container) {
        preview.src = e.target.result;
        container.style.display = "block";
      }
    };

    reader.readAsDataURL(file);
  }
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", function () {
  // Auto-hide alerts after 5 seconds
  const alerts = document.querySelectorAll(".alert");
  alerts.forEach((alert) => {
    setTimeout(() => {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }, 5000);
  });

  // Add smooth scroll behavior
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });
});

// Confirm delete with better UX
function confirmServicesDelete(id) {
  if (
    confirm("هل أنت متأكد من حذف هذا العنصر؟\nلا يمكن التراجع عن هذا الإجراء.")
  ) {
    // In real app: send delete request
    window.location.href = "services.php?action=delete&id=" + id;
  }
}
function confirmPartnersDelete(id) {
  if (
    confirm("هل أنت متأكد من حذف هذا العنصر؟\nلا يمكن التراجع عن هذا الإجراء.")
  ) {
    // In real app: send delete request
    window.location.href = "partner.php?action=delete&id=" + id;
  }
}

// Copy to clipboard function
function copyToClipboard(text) {
  if (navigator.clipboard) {
    navigator.clipboard.writeText(text).then(
      function () {
        showToast("تم النسخ بنجاح!", "success");
      },
      function () {
        showToast("فشل النسخ", "danger");
      },
    );
  }
}

// Toast notification helper
function showToast(message, type = "info") {
  // Simple toast implementation
  const toast = document.createElement("div");
  toast.className = `alert alert-${type} position-fixed top-0 start-50 translate-middle-x mt-3`;
  toast.style.zIndex = "9999";
  toast.textContent = message;

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.remove();
  }, 3000);
}

// Form validation helper
function validateForm(formId) {
  const form = document.getElementById(formId);
  if (form) {
    form.addEventListener("submit", function (e) {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add("was-validated");
    });
  }
}
