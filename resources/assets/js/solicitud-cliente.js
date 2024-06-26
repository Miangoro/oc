
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
  if (wizardIconsBtnSubmit) {
    wizardIconsBtnSubmit.addEventListener('click', event => {
      alert('Submitted..!!');
    });
  }
}

