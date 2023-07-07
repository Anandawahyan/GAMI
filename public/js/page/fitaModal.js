document.addEventListener("DOMContentLoaded", function () {
  var slider = document.getElementById("prefslider");
  var sliderValueElement = document.getElementById("slider-value");

  slider.addEventListener("input", function () {
    sliderValueElement.textContent = getSliderLabel(this.value);
  });

  function getSliderLabel(value) {
    switch (value) {
      case "1":
        return "Sangat Ketat";
      case "2":
        return "Ketat";
      case "3":
        return "Pas";
      case "4":
        return "Longgar";
      case "5":
        return "Sangat Longgar";
      default:
        return "Pas";
    }
  }
});

function submitFormBmi() {
  // Get the input values

  var umur = document.getElementById("umurInput").value;
  var tinggi = document.getElementById("tinggiInput").value;
  var berat = document.getElementById("beratInput").value;

  // Do something with the input values
  console.log(umur);
  console.log(tinggi);
  console.log(berat);
  return {
    umur,
    tinggi,
    berat,
  };
}
function submitFormPerut() {
  // Get the input values
  const buttons = document.querySelectorAll('input[name="perut"]');
  let perut = null;

  buttons.forEach((button) => {
    if (button.classList.contains("active")) {
      perut = button.value;
    }
  });

  if (perut) {
    console.log(perut);
  } else {
    console.log("Please select an option for perut");
  }
  return perut;
}

// Add event listeners to the buttons
const perutButtons = document.querySelectorAll('input[name="perut"]');
perutButtons.forEach((button) => {
  button.addEventListener("click", function () {
    perutButtons.forEach((btn) => btn.classList.remove("active"));
    button.classList.add("active");
  });
});

function submitFormDada() {
  // Get the input values
  const buttons = document.querySelectorAll('input[name="dada"]');
  let dada = null;

  buttons.forEach((button) => {
    if (button.classList.contains("active")) {
      dada = button.value;
    }
  });

  if (dada) {
    console.log(dada);
  } else {
    console.log("Please select an option for dada");
  }
  return dada;
}

// Add event listeners to the buttons
const dadaButtons = document.querySelectorAll('input[name="dada"]');
dadaButtons.forEach((button) => {
  button.addEventListener("click", function () {
    dadaButtons.forEach((btn) => btn.classList.remove("active"));
    button.classList.add("active");
  });
});

function sliderValue() {
  var sliderValue = document.getElementById("prefslider").value;
  function getSliderLabel(sliderValue) {
    switch (sliderValue) {
      case "1":
        return "very tight";
      case "2":
        return "tight";
      case "3":
        return "fit or average";
      case "4":
        return "Loose";
      case "5":
        return "oversized";
      default:
        return "fit or average";
    }
  }
  console.log(getSliderLabel(sliderValue));
  return getSliderLabel(sliderValue);
}
function processInput() {
  const umur = submitFormBmi().umur;
  const tinggi = submitFormBmi().tinggi;
  const berat = submitFormBmi().berat;
  const perut = submitFormPerut();
  const dada = submitFormDada();
  const prefSlider = sliderValue();

  const prompt = `male,weight ${berat} kg, height ${tinggi} cm, age ${umur}, ${perut} tummy size, ${dada} chest size, prefer ${prefSlider} clothes. `;
  console.log(prompt);
  const apiUrl = "https://api.openai.com/v1/chat/completions";
  const apiKey = "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";

  fetch(apiUrl, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${apiKey}`,
    },
    body: JSON.stringify({
      messages: [
        {
          role: "system",
          content:
            "based on those criteria, recommend the size of clothes with eu, uk, us, and asia size measurement. reply with the size recommendation for each measurement. give a percentage to show how well the person and the clothes match. answer in a bulleted list and don't add your opinion.",
        },
        { role: "user", content: prompt },
      ],
      max_tokens: 1024,
      temperature: 0.25,
      model: "gpt-3.5-turbo",
    }),
  })
    .then((response) => response.json())
    .then((output) => {
      const recommendation = output.choices[0].message.content;
      console.log(recommendation);
      document.getElementById("output").textContent = recommendation;
    })
    .catch((error) => {
      console.log(error);
    });
}
