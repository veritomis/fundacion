// generarFakers.js
import { faker } from "https://cdn.jsdelivr.net/npm/@faker-js/faker@8.4.0/+esm";

async function generarFakers() {
  const url = 'guardar.php';

  const hoy = new Date();

  for (let i = 0; i < 50; i++) {
    const fechaDonacion = new Date();

    if (i < 40) {
      fechaDonacion.setMonth(hoy.getMonth() - (3 + Math.floor(Math.random() * 6)));
    } else {
      fechaDonacion.setDate(hoy.getDate() - Math.floor(Math.random() * 30));
    }

    const formData = new FormData();
    formData.append('nombre', faker.person.fullName());
    formData.append('dni', faker.number.int({ min: 10000000, max: 50000000 }));
    formData.append('email', faker.internet.email());
    formData.append('celular', faker.phone.number('11########'));
    formData.append('sexo', faker.person.sex());
    formData.append('domicilio', faker.location.streetAddress());
    formData.append('localidad', faker.location.city());
    formData.append('provincia', faker.location.state());
    formData.append('mensaje', faker.lorem.sentence());
    formData.append('fecha_ultima_donacion', fechaDonacion.toISOString().split('T')[0]);
    formData.append('rol[]', 'dador');
    formData.append('rol[]', 'colaborador');
    formData.append('rol[]', 'acompañante');

    try {
      const res = await fetch(url, { method: 'POST', body: formData });
      const text = await res.text();
      console.log(`Registro ${i + 1} guardado. Respuesta:`, text);
    } catch (error) {
      console.error(`Error en el registro ${i + 1}:`, error);
    }
  }

  console.log("✅ Todos los fakers enviados.");
}

// Ejecutar solo cuando se llame manualmente
window.generarFakers = generarFakers;
