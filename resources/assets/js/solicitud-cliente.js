



    document.addEventListener('DOMContentLoaded', function() {
      const mezcalCheckbox = document.getElementById('customRadioIcon1');
      const bebidaCheckbox = document.getElementById('customRadioIcon2');
      const coctelCheckbox = document.getElementById('customRadioIcon3');
      const licorCheckbox = document.getElementById('customRadioIcon4');
      const nom070Checkbox = document.getElementById('customRadioIcon5');
      const nom251Checkbox = document.getElementById('customRadioIcon6');
      const normexCheckbox = document.getElementById('customRadioIcon7');

      function updateBorder(checkbox) {
          const parentDiv = checkbox.closest('.custom-option');
          if (checkbox.checked) {
              parentDiv.classList.add('active');
          } else {
              parentDiv.classList.remove('active');
          }
      }

      function mostrarSecciones() {
        console.log('mezcalCheckbox:', mezcalCheckbox.checked);
        console.log('bebidaCheckbox:', bebidaCheckbox.checked);
        console.log('coctelCheckbox:', coctelCheckbox.checked);
        console.log('licorCheckbox:', licorCheckbox.checked);
          if (mezcalCheckbox.checked) {
              nom070Checkbox.checked = true;
              nom251Checkbox.checked = true;
          } else {
              nom070Checkbox.checked = false;
              nom251Checkbox.checked = false;
          }

          if (bebidaCheckbox.checked || coctelCheckbox.checked || licorCheckbox.checked) {
              nom251Checkbox.checked = true;
              normexCheckbox.checked = true;
          } else {
              normexCheckbox.checked = false;
          }

          updateBorder(nom070Checkbox);
          updateBorder(nom251Checkbox);
          updateBorder(normexCheckbox);

          toggleSectionVisibility('nom070-section', nom070Checkbox.checked);
          toggleSectionVisibility('normex-section', normexCheckbox.checked);
      }

      function toggleSectionVisibility(sectionId, shouldShow) {
          let section = document.getElementById(sectionId);
          if (section) {
              section.style.display = shouldShow ? 'block' : 'none';
          } else {
              if (shouldShow) {
                  section = (sectionId === 'nom070-section') ? crearNOM070Section() : crearNormexSection();
                  const socialLinks = document.getElementById('social-links');
                  socialLinks.insertBefore(section, socialLinks.lastElementChild);
                  // Reapply border styles to dynamically added checkboxes
                  section.querySelectorAll('.form-check-input').forEach(input => {
                      input.addEventListener('change', function() {
                          updateBorder(input);
                      });
                  });
              }
          }
      }

      function mostrarRepresentante(){
        var regimen = document.getElementById("regimen").value;
        var representante = document.getElementById('representante');
        var nombreRepresentante = document.getElementById('nombreRepresentante');
        if(regimen=="Persona moral"){ 
            representante.style.display = "block";
            nombreRepresentante.setAttribute("required", "required");
        }
        if(regimen=="Persona física"){
            representante.style.display = "none";
            nombreRepresentante.removeAttribute("required");
        }

      }

      function crearNOM070Section() {
          const nom070Section = document.createElement('div');
          nom070Section.id = 'nom070-section';

          nom070Section.innerHTML = `
              <h6 class="my-4">Actividad del cliente NOM-070-SCFI-2016:</h6>
              <div class="row gy-3 align-items-start">
                  <div class="col-md">
                      <div class="form-check custom-option custom-option-icon">
                          <label class="form-check-label custom-option-content" for="customRadioIcon8">
                              <span class="custom-option-body">
                                  <i class="icon-agave"></i>
                                  <small>Productor de Agave</small>
                              </span>
                              <input name="actividad[]" class="form-check-input" type="checkbox" value="1" id="customRadioIcon8" />
                          </label>
                      </div>
                  </div>
                  <div class="col-md">
                      <div class="form-check custom-option custom-option-icon">
                          <label class="form-check-label custom-option-content" for="customRadioIcon9">
                              <span class="custom-option-body">
                                  <i class="icon-envasador"></i>
                                  <small>Envasador de Mezcal</small>
                              </span>
                              <input name="actividad[]" class="form-check-input" type="checkbox" value="2" id="customRadioIcon9" />
                          </label>
                      </div>
                  </div>
                  <div class="col-md">
                      <div class="form-check custom-option custom-option-icon">
                          <label class="form-check-label custom-option-content" for="customRadioIcon10">
                              <span class="custom-option-body">
                                  <i class="icon-productor-tequila"></i>
                                  <small>Productor de Mezcal</small>
                              </span>
                              <input name="actividad[]" class="form-check-input" type="checkbox" value="3" id="customRadioIcon10" />
                          </label>
                      </div>
                  </div>
                  <div class="col-md">
                      <div class="form-check custom-option custom-option-icon">
                          <label class="form-check-label custom-option-content" for="customRadioIcon11">
                              <span class="custom-option-body">
                                  <i class="icon-comercializador"></i>
                                  <small>Comercializador de Mezcal</small>
                              </span>
                              <input name="actividad[]" class="form-check-input" type="checkbox" value="4" id="customRadioIcon11" />
                          </label>
                      </div>
                  </div>
              </div>
              <hr>
          `;

          return nom070Section;
      }

      function crearNormexSection() {
          const normexSection = document.createElement('div');
          normexSection.id = 'normex-section';

          normexSection.innerHTML = `
              <h6 class="my-4">Actividad del cliente NMX-V-052-NORMEX-2016:</h6>
              <div class="row gy-3 align-items-start">
                  <div class="col-md">
                      <div class="form-check custom-option custom-option-icon">
                          <label class="form-check-label custom-option-content" for="customRadioIcon12">
                              <span class="custom-option-body">
                                  <i class="ri-ink-bottle-fill"></i>
                                  <small>Productor de bebidas alcohólicas que contienen Mezcal</small>
                              </span>
                              <input name="actividad[]" class="form-check-input" type="checkbox" value="5" id="customRadioIcon12" />
                          </label>
                      </div>
                  </div>
                  <div class="col-md">
                      <div class="form-check custom-option custom-option-icon">
                          <label class="form-check-label custom-option-content" for="customRadioIcon13">
                              <span class="custom-option-body">
                                  <i class="ri-ink-bottle-fill"></i>
                                  <small>Envasador de bebidas alcohólicas que contienen Mezcal</small>
                              </span>
                              <input name="actividad[]" class="form-check-input" type="checkbox" value="6" id="customRadioIcon13" />
                          </label>
                      </div>
                  </div>
                  <div class="col-md">
                      <div class="form-check custom-option custom-option-icon">
                          <label class="form-check-label custom-option-content" for="customRadioIcon15">
                              <span class="custom-option-body">
                                  <i class="ri-ink-bottle-fill"></i>
                                  <small>Comercializador de bebidas alcohólicas que contienen Mezcal</small>
                              </span>
                              <input name="actividad[]" class="form-check-input" type="checkbox" value="7" id="customRadioIcon15" />
                          </label>
                      </div>
                  </div>
              </div>
              <hr>
          `;

          return normexSection;
      }

      const checkboxes = [
          mezcalCheckbox, bebidaCheckbox, coctelCheckbox, licorCheckbox,
          nom070Checkbox, nom251Checkbox, normexCheckbox
      ];

      checkboxes.forEach(function(checkbox) {
          checkbox.addEventListener('change', function() {
              updateBorder(checkbox);
              mostrarSecciones();
          });
      });

      document.getElementById('regimen').addEventListener('change', function() {
        mostrarRepresentante();
      
    });
  
      mostrarSecciones();
    });


const wizardIcons = document.querySelector('.wizard-icons-example');

if (typeof wizardIcons !== undefined && wizardIcons !== null) {
  const wizardIconsBtnNextList = [].slice.call(wizardIcons.querySelectorAll('.btn-next')),
    wizardIconsBtnPrevList = [].slice.call(wizardIcons.querySelectorAll('.btn-prev')),
    wizardIconsBtnSubmit = wizardIcons.querySelector('.btn-submit');

  const iconsStepper = new Stepper(wizardIcons, {
    linear: false
  });
  if (wizardIconsBtnNextList) {
    wizardIconsBtnNextList.forEach(wizardIconsBtnNext => {
      wizardIconsBtnNext.addEventListener('click', event => {
        iconsStepper.next();
      });
    });
  }
  if (wizardIconsBtnPrevList) {
    wizardIconsBtnPrevList.forEach(wizardIconsBtnPrev => {
      wizardIconsBtnPrev.addEventListener('click', event => {
        iconsStepper.previous();
      });
    });
  }
  /*if (wizardIconsBtnSubmit) {
    wizardIconsBtnSubmit.addEventListener('click', event => {
      alert('Submitted..!!');
    });
  }*/
}



new Cleave(".phone-number-mask", {
    phone: true,
    phoneRegionCode: "US"
  });

/*  */document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[name="producto[]"]');
    const specificAddressSection = document.getElementById('specific-address-section');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            specificAddressSection.innerHTML = ''; // Clear existing fields
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    const label = cb.nextElementSibling.querySelector('small').textContent;
                    const addressHtml = `
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Domicilio Fiscal</h6>
                            <small>Ingrese los datos del domicilio fiscal del ${label}</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="localidad-${cb.value}" name="localidad_${cb.value}" required placeholder=" ">
                                    <label for="localidad-${cb.value}">Domicilio completo</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control custom-select" name="estado_${cb.value}" id="estado_${cb.value}" aria-label="Estado" required>
                                        <option disabled selected>Selecciona un estado</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado }}">{{ $estado }}</option>
                                        @endforeach
                                    </select>
                                    <label for="estado_${cb.value}">Estado</label>
                                </div>
                            </div>
                        </div>
                    `;
                    specificAddressSection.insertAdjacentHTML('beforeend', addressHtml);
                }
            });
        });
    });
});
