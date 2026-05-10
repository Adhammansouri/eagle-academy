document.addEventListener("DOMContentLoaded", () => {
  // 1. Initialize Chart.js configuration globally
  if (typeof Chart !== 'undefined') {
    Chart.defaults.color = "#9ea4a8";
    Chart.defaults.font.family = "'Cairo', sans-serif";
  }

  // 2. Setup Category Chart (Doughnut) - براعم vs شباب
  const categoryCanvas = document.getElementById("categoryChart");
  let categoryChart;
  if(categoryCanvas && typeof Chart !== 'undefined') {
    const categoryCtx = categoryCanvas.getContext("2d");
    categoryChart = new Chart(categoryCtx, {
      type: "doughnut",
      data: {
        labels: ["براعم", "شباب"],
      datasets: [
        {
          data: [
            window.chartData?.categories?.kids || 0,
            window.chartData?.categories?.youth || 0
          ],
          backgroundColor: [
            "#D32F2F", // Eagle Red
            "#9EA4A8", // Light Grey
          ],
          borderWidth: 0,
          hoverOffset: 6,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            padding: 20,
            color: "#ffffff",
            font: { size: 14, family: "Cairo" },
          },
        },
        tooltip: {
          backgroundColor: "rgba(30,34,39,0.9)",
          titleFont: { family: "Cairo", size: 14 },
          bodyFont: { family: "Cairo", size: 14 },
          padding: 12,
          cornerRadius: 8,
        },
      },
      },
    });
  }

  // 3. Setup Source Chart (Bar) - الأكاديمية vs فورس جيم
  const sourceCanvas = document.getElementById("sourceChart");
  let sourceChart;
  if(sourceCanvas && typeof Chart !== 'undefined') {
    const sourceCtx = sourceCanvas.getContext("2d");
    sourceChart = new Chart(sourceCtx, {
      type: "bar",
      data: {
        labels: ["الأكاديمية", "فورس جيم"],
        datasets: [
          {
            label: "عدد الاشتراكات",
          data: [
            window.chartData?.sources?.academy || 0,
            window.chartData?.sources?.force_gym || 0
          ],
          backgroundColor: [
            "#D32F2F", // Eagle Red
            "#2c323a", // Darker Grey
          ],
          borderRadius: 6,
          borderSkipped: false,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: "rgba(255,255,255,0.05)" },
          ticks: { stepSize: 10 },
        },
        x: {
          grid: { display: false },
          ticks: { color: "#ffffff", font: { size: 14, family: "Cairo" } },
        },
      },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: "rgba(30,34,39,0.9)",
          titleFont: { family: "Cairo" },
          bodyFont: { family: "Cairo" },
          padding: 12,
          cornerRadius: 8,
        },
      },
      },
    });
  }

  // 4. Handle Form Submission Interactively
  const form = document.getElementById("subscriptionForm");
  if(form) {
    const submitBtn = document.getElementById("submitBtn");

  // Stats elements (might not exist on the form page)
    const totalPlayersEl = document.getElementById("totalPlayers");
  const newSubsEl = document.getElementById("newSubs");

  // Dynamic Category Logic
  const sourceDropdown = document.getElementById("source");
  const categoryGroup = document.getElementById("categoryGroup");
  const categoryDropdown = document.getElementById("category");

  if(sourceDropdown && categoryGroup && categoryDropdown) {
      function toggleCategoryVisibility() {
          if(sourceDropdown.value === "الاكاديميه") {
              categoryGroup.style.display = "block";
              categoryDropdown.required = true;
          } else {
              categoryGroup.style.display = "none";
              categoryDropdown.required = false;
              if (sourceDropdown.value !== "") {
                  categoryDropdown.value = ""; // Reset value only if a source was selected
              }
          }
      }

      // Listen for changes
      sourceDropdown.addEventListener("change", toggleCategoryVisibility);
      
      // Run once on load to catch pre-selected values or auto-fills
      toggleCategoryVisibility();
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const playerName = document.getElementById("playerName").value;
    const birthDate = document.getElementById("birthDate").value;
    const amount = document.getElementById("amount").value;
    const subDate = document.getElementById("subDate").value;
    const expDate = document.getElementById("expDate").value;
    const category = document.getElementById("category").value;
    const source = document.getElementById("source").value;

    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = "جاري الحفظ... ⏳";
    submitBtn.disabled = true;

    try {
        const response = await fetch('/api/players', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: playerName,
                birth_year: birthDate,
                phone_number: document.getElementById("phoneNumber").value,
                fee: amount,
                subscription_date: subDate,
                expiration_date: expDate,
                category: category,
                source: source
            })
        });

        const result = await response.json();

        if (response.ok && result.success) {
            
            // Only update charts if they exist on the page
            if(categoryChart) {
                if (category === "براعم") {
                  categoryChart.data.datasets[0].data[0]++;
                } else if (category === "شباب") {
                  categoryChart.data.datasets[0].data[1]++;
                }
                categoryChart.update();
            }

            if(sourceChart) {
                if (source === "الاكاديميه") {
                  sourceChart.data.datasets[0].data[0]++;
                } else if (source === "فورس جيم") {
                  sourceChart.data.datasets[0].data[1]++;
                }
                sourceChart.update();
            }

            if(totalPlayersEl) totalPlayersEl.textContent = parseInt(totalPlayersEl.textContent) + 1;
            if(newSubsEl) newSubsEl.textContent = parseInt(newSubsEl.textContent) + 1;

            // Animate Button for Success
            submitBtn.innerHTML = "تم تسجيل اللاعب بنجاح ✔";
            submitBtn.style.background = "linear-gradient(135deg, #2ecc71 0%, #27ae60 100%)";
            submitBtn.style.boxShadow = "0 4px 15px rgba(46, 204, 113, 0.4)";

            // Reset form and button after 3 seconds
            setTimeout(() => {
              submitBtn.innerHTML = originalText;
              submitBtn.style.background = ""; // restore class default
              submitBtn.style.boxShadow = "";
              submitBtn.disabled = false;
              form.reset();
            }, 3000);
        } else {
            alert('يوجد خطأ في البيانات المحفوظة، يرجى المراجعة: ' + (result.message || ''));
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    } catch (error) {
        alert('حدث خطأ في الاتصال بالخادم. يرجى المحاولة لاحقاً.');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
  });
  } // end if(form)
});
