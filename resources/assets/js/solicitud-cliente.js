



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


    window.estadosOptions = `
    @foreach ($estados as $estado)
        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
    @endforeach
`;


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



  document.addEventListener('DOMContentLoaded', () => {
    // Función para mostrar u ocultar secciones según el checkbox seleccionado
    function toggleSection() {
        // Obtener el estado de cada checkbox
        const agaveCheckbox = document.getElementById('customRadioIcon8');
        const envasadorCheckbox = document.getElementById('customRadioIcon9');
        const productorMezcalCheckbox = document.getElementById('customRadioIcon10');
        const comercializadorCheckbox = document.getElementById('customRadioIcon11');

        // Mostrar u ocultar secciones basadas en los checkboxes seleccionados
        document.getElementById('domiProductAgace').style.display = agaveCheckbox.checked ? 'block' : 'none';
        document.getElementById('domiEnvasaMezcal').style.display = envasadorCheckbox.checked ? 'block' : 'none';
        document.getElementById('domiProductMezcal').style.display = productorMezcalCheckbox.checked ? 'block' : 'none';
        document.getElementById('domiComerMezcal').style.display = comercializadorCheckbox.checked ? 'block' : 'none';
        
        // Limpia los campos de las secciones ocultas
        if (!agaveCheckbox.checked) {
            document.getElementById('domiProductAgace').querySelectorAll('input[type="text"]').forEach(input => input.value = '');
            document.getElementById('domiProductAgace').querySelectorAll('select').forEach(select => select.selectedIndex = 0);
        }
        if (!envasadorCheckbox.checked) {
            document.getElementById('domiEnvasaMezcal').querySelectorAll('input[type="text"]').forEach(input => input.value = '');
            document.getElementById('domiEnvasaMezcal').querySelectorAll('select').forEach(select => select.selectedIndex = 0);
        }
        if (!productorMezcalCheckbox.checked) {
            document.getElementById('domiProductMezcal').querySelectorAll('input[type="text"]').forEach(input => input.value = '');
            document.getElementById('domiProductMezcal').querySelectorAll('select').forEach(select => select.selectedIndex = 0);
        }
        if (!comercializadorCheckbox.checked) {
            document.getElementById('domiComerMezcal').querySelectorAll('input[type="text"]').forEach(input => input.value = '');
            document.getElementById('domiComerMezcal').querySelectorAll('select').forEach(select => select.selectedIndex = 0);
        }
    }

    // Añadir event listeners a los checkboxes
    document.getElementById('customRadioIcon8').addEventListener('change', toggleSection);
    document.getElementById('customRadioIcon9').addEventListener('change', toggleSection);
    document.getElementById('customRadioIcon10').addEventListener('change', toggleSection);
    document.getElementById('customRadioIcon11').addEventListener('change', toggleSection);
    
    // Inicializa el estado de las secciones al cargar la página
    toggleSection();
});

/* seccion del switch */

document.addEventListener('DOMContentLoaded', () => {
    const switchInput = document.querySelector('.switch-input');
    const localidad1 = document.getElementById('localidad1');
    const estado = document.getElementById('estado');

    // Función para copiar los datos del primer domicilio a las secciones visibles
    function copyAddress() {
        // Obtener todos los contenedores de domicilio fiscal
        const addressContainers = [
            document.getElementById('domiProductAgace'),
            document.getElementById('domiEnvasaMezcal'),
            document.getElementById('domiProductMezcal'),
            document.getElementById('domiComerMezcal')
        ];
        
        if (switchInput.checked) {
            // Copiar datos si el switch está marcado
            addressContainers.forEach(container => {
                if (container.style.display !== 'none') {
                    const localidadInput = container.querySelector('input[type="text"]');
                    const estadoSelect = container.querySelector('select');
                    
                    if (localidadInput && estadoSelect) {
                        localidadInput.value = localidad1.value;
                        estadoSelect.value = estado.value;
                    }
                }
            });
        } else {
            // Vaciar campos si el switch no está marcado
            addressContainers.forEach(container => {
                if (container.style.display !== 'none') {
                    const localidadInput = container.querySelector('input[type="text"]');
                    const estadoSelect = container.querySelector('select');
                    
                    if (localidadInput && estadoSelect) {
                        localidadInput.value = '';
                        estadoSelect.selectedIndex = 0; // Resetea la selección del <select>
                    }
                }
            });
        }
    }

    // Escuchar cambios en el switch
    switchInput.addEventListener('change', copyAddress);
});