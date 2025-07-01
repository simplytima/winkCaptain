const phoneCodeMap = {
    "MA": "+212",
    "US": "+1",
    "GB": "+44",
    "IN": "+91"
};

  function getPhoneCode(countryCode) {
    return phoneCodeMap[countryCode] || "+212";
 }

  async function detectCountry() {
    try {
      const cachedCountry = localStorage.getItem("countryCode");
      if (cachedCountry && phoneCodeMap[cachedCountry]) {
        document.getElementById("countrycode").value = getPhoneCode(cachedCountry);
        return;
     }

      const response = await fetch("https://ip2c.org/s");
      const data = await response.text();

      if (data && data.length > 0) {
        const parts = data.split(';');
        if (parts.length >= 2) {
          const countryCode = parts[1];
          const phoneCode = getPhoneCode(countryCode);

          document.getElementById("countrycode").value = phoneCode;
          localStorage.setItem("countryCode", countryCode);
        }
      }
    } catch (error) {
      console.error("Failed to detect country:", error);
      document.getElementById("countrycode").value = "+1";
    }
  }

  const loginInput = document.getElementById("login");
  const termsCheckbox = document.getElementById("terms");
  const emailBtn = document.getElementById("get-email-code");
  const smsBtn = document.getElementById("get-sms-code");
  const whatsappBtn = document.getElementById("get-whatsapp-code");
  const countrycodeSelect = document.getElementById("countrycode");
  const qrButton = document.getElementById("qr-button");
  const qrModal = document.getElementById("qr-modal");
  const closeQrButton = document.getElementById("close-qr");

  const isPhone = val => /^\+?[0-9]{6,15}$/.test(val);
  const isEmail = val => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);

  function updateButtons() {
    const val = loginInput.value.trim();
    const accepted = termsCheckbox.checked;

    emailBtn.classList.add("hidden");
    smsBtn.classList.add("hidden");
    whatsappBtn.classList.add("hidden");
    countrycodeSelect.classList.add("hidden");

    if (val.length > 0 && (!isNaN(val[0]) || val.startsWith('+'))) {
      smsBtn.classList.remove("hidden");
      whatsappBtn.classList.remove("hidden");
      countrycodeSelect.classList.remove("hidden");
      setBtnState(smsBtn, accepted);
      setBtnState(whatsappBtn, accepted);
    } else if (isEmail(val)) {
      emailBtn.classList.remove("hidden");
      setBtnState(emailBtn, accepted);
    } else {
      emailBtn.classList.remove("hidden");
      setBtnState(emailBtn, false);
    }
  }

  function setBtnState(btn, enable) {
    btn.disabled = !enable;
    btn.classList.remove("bg-gray-300", "text-gray-600", "cursor-not-allowed", "bg-green-500", "text-white", "cursor-pointer");
    if (enable) {
      btn.classList.add("bg-green-500", "text-white", "cursor-pointer");
    } else {
      btn.classList.add("bg-gray-300", "text-gray-600", "cursor-not-allowed");
    }
  }

  qrButton.addEventListener("click", () => {
    qrModal.classList.remove("hidden");
  });

  closeQrButton.addEventListener("click", () => {
    qrModal.classList.add("hidden");
  });

  qrModal.addEventListener("click", (e) => {
    if (e.target === qrModal) {
      qrModal.classList.add("hidden");
    }
  });

  loginInput.addEventListener("input", updateButtons);
  termsCheckbox.addEventListener("change", updateButtons);

  detectCountry();
  updateButtons();