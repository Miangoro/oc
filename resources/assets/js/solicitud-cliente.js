
document.addEventListener('DOMContentLoaded', function() {
    

  // Contador para nuevas direcciones
  let addressCounter = 1;

  // Función para clonar la dirección
  function cloneAddress() {
      addressCounter++;
      let clonedAddress = document.getElementById('address1').cloneNode(true);
      clonedAddress.id = 'address' + addressCounter;

      // Limpiar los valores de los inputs clonados
      clonedAddress.querySelectorAll('input').forEach(input => {
          input.value = '';
      });

      // Asegurar que los ID de los inputs sean únicos
      clonedAddress.querySelectorAll('input').forEach((input, index) => {
          input.id = input.id.slice(0, -1) + addressCounter; // Cambiar el número en el ID
          input.name = input.name.slice(0, -1) + addressCounter; // Cambiar el número en el name
          input.nextElementSibling.setAttribute('for', input.id); // Actualizar el label for
      });

      // Crear botón de eliminar con icono
      let deleteBtn = document.createElement('button');
      deleteBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'mt-2', 'ms-2'); // Ajustar la clase ms-2 para el margen izquierdo
      deleteBtn.type = 'button';
      
      // Agregar icono de Remix Icon
      let icon = document.createElement('i');
      icon.classList.add('ri-delete-bin-6-line', 'me-1'); // Clase del icono de Remix Icon
      deleteBtn.appendChild(icon);

      // Texto del botón
      deleteBtn.appendChild(document.createTextNode('Eliminar'));

      deleteBtn.addEventListener('click', function() {
          clonedAddress.remove();
          hrElement.remove(); // Eliminar también el HR asociado
      });

      // Agregar el botón de eliminar después del campo de C.P.
      let hrElement = document.createElement('hr');
      hrElement.classList.add('mt-4', 'mb-4'); // Ajusta los márgenes del HR si es necesario

      // Agregar el HTML clonado al contenedor
      let container = document.getElementById('clonedAddresses');
      container.appendChild(clonedAddress);
      container.appendChild(hrElement);
      hrElement.appendChild(deleteBtn);
  }

  // Evento click para el botón de agregar dirección
  document.getElementById('addAddressBtn').addEventListener('click', function() {
      cloneAddress();
  });

  // Función para eliminar una dirección clonada
  window.deleteAddress = function(element) {
      let row = element.closest('.row');
      let hrElement = row.nextElementSibling; // Obtener el HR siguiente al elemento a eliminar
      row.remove(); // Elimina el elemento padre .row más cercano
      if (hrElement.tagName === 'HR') {
          hrElement.remove(); // Eliminar el HR si existe
      }
  };
});


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
