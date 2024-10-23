-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2024 a las 00:22:32
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `oc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacion`
--

CREATE TABLE `documentacion` (
  `id_documento` int(11) NOT NULL,
  `nombre` varchar(280) NOT NULL,
  `tipo` varchar(150) NOT NULL,
  `subtipo` varchar(50) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `documentacion`
--

INSERT INTO `documentacion` (`id_documento`, `nombre`, `tipo`, `subtipo`, `orden`) VALUES
(1, 'Acta constitutiva (Copia simple)', 'Documentos generales', 'Todas', 0),
(2, 'Poder notarial del representante legal (Solo en caso de no estar incluido en el acta constitutiva)', 'Documentos generales', 'Todas', 0),
(3, 'Copia de identificacion oficial del Titular (encaso de ser persona física) o representante legal (en caso de ser persona moral).', 'Documentos generales', 'Todas', 1),
(4, 'Comprobante del domicilio fiscal', 'Documentos generales', 'Todas', 0),
(5, 'Contrato de prestación de servicios (Proporcionado por el OCP del CIDAM)', 'Documentos generales', 'Todas', 2),
(6, 'Comprobante del domicilio (Unidad de producción, envasado o comercialización, almacén\r\n', 'Documentos generales', 'Todas', 0),
(7, 'Certificado vigente que demuestre el cumplimiento con su respectiva norma', 'Bebidas alcóholicas nacionales con denominación de origen que cuenten con persona acreditada y aprobada', 'Denominación de origen', 0),
(8, 'Revisión de la etiqueta mediante NOM-142-SSA1/SCFI-2014 y la NOM-|99-SCFI-2017', 'Bebidas alcóholicas nacionales con denominación de origen que cuenten con persona acreditada y aprobada', 'Denominación de origen', 0),
(9, 'Carta del fabricante', 'Bebidas Alcohólicas importada reconocida como indicación geográfica o producto distintivo', 'Importador', 0),
(10, 'Certificado de libre venta (Certificado o documento emitido por la autoridad competente que cumple con las especificaciones del país de origen según su legislación)', 'Bebidas Alcohólicas importada reconocida como indicación geográfica o producto distintivo', 'Importador', 0),
(11, 'Informe de resultados emitido por el laboratorio Acreditado y aprobado', 'Bebidas Alcohólicas importada reconocida como indicación geográfica o producto distintivo', 'ImportadorNO', 0),
(12, 'Revisión de la etiqueta mediante NOM-142-SSA1/SCFI-2014 y la NOM-|99-SCFI-2017', 'Bebidas Alcohólicas importada reconocida como indicación geográfica o producto distintivo', 'ImportadorNO', 0),
(13, 'Declaración de la conformidad emitido por la unidad de verificación, incluyendo el reporte de descripción general del producto y marca comercial o marca registrada/titulo marcario', 'Bebidas alcohólicas fermentadas', 'Fermentadas', 0),
(14, 'Informe de resultados emitido por ellaboratorio Acreditado y aprobado', 'Bebidas alcohólicas fermentadas', 'Fermentadas', 0),
(15, 'Aprobación e la etiqueta mediante NOM-142-SSA1/SCFI-2014 y la NOM-199-SCFI-2017', 'Bebidas alcohólicas fermentadas', 'Fermentadas', 0),
(16, 'Carta del fabricante', 'Para bebida alcohólica fermentada importada', 'Fermentadas-Importador', 0),
(17, 'Declaración de la conformidad emitido por la unidad de verificación, incluyendo el reporte de descripción general del producto y marca comercial o marca registrada/titulo marcario', 'Bebida alcohólica destilada', 'Destiladas', 0),
(18, 'Informe de resultados emitido por ellaboratorio Acreditado y aprobado', 'Bebida alcohólica destilada', 'Destiladas', 0),
(19, 'Aprobación e la etiqueta mediante NOM-142-SSA1/SCFI-2014 y la NOM-199-SCFI-2017', 'Bebida alcohólica destilada', 'Destiladas', 0),
(20, 'Dictamen técnico y autenticidad de la bebida emitido por la unidad de Verificación', 'Bebida alcohólica destilada', 'Destiladas', 0),
(21, 'Una copia del certificado (Que incluya la linea de producción)', 'Cuando se solicita la certificación mediante sistema de calidad', 'Destiladas-Calidad', 0),
(22, 'Carta del fabricante', 'Para el caso de bebida alcohólica destiladas importadas', 'Destiladas-Importador', 0),
(23, 'Certificado de libre venta (Certificado o documento emitido por la autoridad competente que cumple con las especificaciones del país de origen según su legislación)', 'Para el caso de bebida alcohólica destiladas importadas', 'Destiladas-Importador', 0),
(24, 'Traducción simple del certificado de libre venta (Si se presenta en otro idioma)', 'Para el caso de bebida alcohólica destiladas importadas', 'Destiladas-Importador', 0),
(25, 'Declaración de la conformidad emitido por la unidad de verificación, incluyendo el reporte de descripción general del producto y marca comercial o marca registrada/titulo marcario', 'Licores o cremas, cocteles, bebidas alcohólicas preparadas', 'Licores', 0),
(26, 'Informe de resultados emitido por el laboratorio Acreditado y aprobado', 'Licores o cremas, cocteles, bebidas alcohólicas preparadasa', 'Licores', 0),
(27, 'Aprobación e la etiqueta mediante NOM-142-SSA1/SCFI-2014 y la NOM-199-SCFI-2017', 'Licores o cremas, cocteles, bebidas alcohólicas preparadas', 'Licores', 0),
(28, 'Dictamen técnico y autenticidad de la bebida emitido por la unidad de Verificación', 'Licores o cremas, cocteles, bebidas alcohólicas preparadas', 'Licores', 0),
(29, 'Una copia del certificado (Que incluya la linea de producción)', 'Cuando se solicita la certificación mediante sistema de calidad', 'Licores-Calidad', 0),
(30, 'Carta del fabricante', 'Para el caso de bebida alcohólica destiladas importadas', 'Licores-Importador', 0),
(31, 'Certificado de libre venta (Certificado o documento emitido por la autoridad competente que cumple con las especificaciones del país de origen según su legislación)', 'Para el caso de bebida alcohólica destiladas importadas', 'Licores-Importador', 0),
(32, 'Traducción simple del certificado de libre venta (Si se presenta en otro idioma)', 'Para el caso de licores, cocteles,bebidas alcohólicas preparadas importadas', 'Licores-Importador', 0),
(33, 'Carta de designación de persona autorizada para realizar los trámites.', 'Documentos Generales', 'Todas', 0),
(34, 'Contrato de arrendamiento del terreno o copias de escrituras', 'Generales Productor', 'Generales Productor', 0),
(35, 'Copia de la identificación oficial vigente del arrendador y arrendatario (En caso de no ser propietario de las instalaciones)', 'Generales Productor', 'Generales Productor', 0),
(36, 'Formato 32-D Opinión de cumplimiento de obligaciones fiscales del SAT', 'Generales Comercializador', 'Generales Comercializador', 0),
(37, 'Juegos de etiquetas o constancia de cumplimiento emitida por la unidad de verificación titulo de la marca', 'Generales Comercializador', 'Generales Comercializador', 0),
(38, 'Comprobante de trámite de marca (En caso de que su marca este en trámite)', 'Marcas', 'Generales Comercializador', 0),
(39, 'Carta responsiva de trámite (En caso de que su marca este en trámite)', 'Marcas', 'Generales Comercializador', 0),
(40, 'Licencia de uso o cesión de derechos (En caso de no ser propietario de la marca)', 'Marcas', 'Generales Comercializador', 0),
(41, 'Evidencia del vinculo entre productor y/o envasador (contrato de maquila o convenio de corresponsabilidad siempre y cuando mencione el envasado)', 'Generales Comercializador', 'Generales Comercializador', 0),
(42, 'Comprobante de domicilio fiscal ', 'Generales Envasador', 'Generales Envasador', 0),
(43, 'Plano de distribución', 'Generales Envasador', 'Generales Envasador', 0),
(44, 'Identificación oficial del Responsable de la instalación', 'Generales Envasador', 'Generales Envasador', 0),
(45, 'Comprobante de posesión de las instalaciones (si es propietario, este documento debe estar a nombre de la persona física o moral) o contrato de arrendamiento o comodato', 'Generales Envasador', 'Generales Envasador', 0),
(46, 'Copia de identificación oficial del arrendador y arrendatario (en caso de no ser propietario).', 'Generales Envasador', 'Generales Envasador', 0),
(47, 'Dictámenes', 'Documentos generales', 'Todas', 0),
(48, 'Copia de los análisis de laboratorio de cada uno de los lotes', 'Solicitud', 'Hologramas', 0),
(49, 'Constancia de cumplimiento de la etiqueta emitida por UV acreditada en información comercial.', 'Solicitud', 'Hologramas', 0),
(50, 'En caso de vigilancia en producto envasado, adjuntar certificado NOM a granel y certificado de envasado.', 'Solicitud', 'Hologramas', 0),
(51, 'Comprobante de pago', 'Todas', 'Solicitudes', 0),
(52, 'Documento de No. de guía', 'Todas', 'Hologramas', 0),
(53, 'Comprobante de recibido', 'Todas', 'Holograma', 0),
(54, 'Comprobante de mermas', 'Hologramas', 'Mermas', 0),
(55, 'Factura proforma', 'Certificados / dictámenes', 'Exportación', 0),
(56, 'Fisicoquímicos', 'Certificados / dictámenes', 'Exportación', 0),
(57, 'Etiquetas', 'Certificados / dictámenes', 'Exportación', 0),
(58, 'Análisis fisicoquímicos', 'Solicitud general', 'Servicios', 0),
(59, 'Certificado de lote a granel', 'Solicitud general', 'Servicios', 0),
(60, 'Etiquetas', 'Solicitud general', 'Servicios', 0),
(61, 'Factura proforma', 'Solicitud general', 'Certificados', 0),
(62, 'Constancia de inscripción al Padrón de Bebidas Alcohólicas', 'Generales Comercializador', 'Generales Comercializador', 0),
(63, 'Constancia de alta o inscripción en el Padrón de Exportadores Sectorial del SAT (en caso de ser exportador', 'Generales Comercializador', 'Generales Comercializador', 0),
(65, 'Identificación Oficial del Responsable de la Instalación. ', 'Generales Comercializador', 'Generales Comercializador', 0),
(66, 'Comprobante de posesión (si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento o comodato', 'Generales Comercializador', 'Generales Comercializador', 0),
(67, 'Identificación oficial del arrendador y arrendatario (en el caso de no ser propietario).', 'Generales Comercializador', 'Generales Comercializador', 0),
(68, 'INE de la persona autorizada para realizar trámites.', 'Generales Productor', 'Generales Productor8273', 0),
(69, 'Acta de inspección', 'Predio', 'Inspeccion', 0),
(70, 'Fotografías', 'Predio', 'Inspeccion', 0),
(71, 'Guía de traslado de agave', 'Solicitud general', 'Servicios', 0),
(72, 'Mapa (Predio) ', 'Georreferenciacion', 'Gerente', 0),
(73, 'Evidencias', 'Georreferenciacion', 'Gerente', 0),
(74, 'Dictamen firmado y sellado', 'Solicitudes', 'Dictamen', 0),
(75, 'Corrugado', 'Solicitud general', 'Certificados', 0),
(76, 'Constancia de situación fiscal ', 'Documentos generales', 'Todas', 0),
(77, 'Carta de asignación de número de cliente', 'Documentos generales', 'Todas', 0),
(78, 'Solicitud de información al cliente', 'Documentos generales', 'Todas', 0),
(79, 'Copia de identificación oficial vigente de la persona autorizada', 'Documentos generales', 'Todas', 0),
(80, 'Autorización del uso de la DOM ', 'Generales Envasador', 'Generales Productor1111', 0),
(81, 'Registro COFEPRIS', 'Generales Comercializador', 'Generales Comercializador', 0),
(82, 'Convenio de corresponsabilidad inscrito ante el IMPI entre el comercializador y un productor autorizado', 'Marcas', 'Generales Comercializador', 0),
(83, 'Autorización del uso de la Denominación de Origen Mezcal (DOM)', 'Generales Productor', 'Generales Productor Mezcal', 0),
(84, 'Plan orgánico conforme a la actividad agropecuaria que desarrolla.', 'Documentacion organico', 'Solicitud', 0),
(85, 'Historial de campo', 'Documentacion organico', 'Solicitud', 0),
(86, 'Reglamento Interno de Producción Orgánica para grupos de productores en caso de grupos de productores cumpliendo los requisitos mínimos establecidos en el presente Acuerdo.', 'Documentacion organico', 'Solicitud', 0),
(87, 'Copia del certificado anterior, si es una ampliación de la certificación', 'Documentacion organico', 'Solicitud', 0),
(88, 'Carta Compromiso, por parte del Operador para llevar a cabo las operaciones de conformidad con las regulaciones vigentes establecidas.', 'Documentacion organico', 'Solicitud', 0),
(89, 'Mapas de todas las parcelas y|o áreas incluidas en la unidad productiva.', 'Documentacion organico', 'Solicitud', 0),
(90, 'Fotos etiquetas', 'Revisión', 'Etiquetas', 0),
(91, 'Copia del certificado actual de la certificación orgánica aplicable al cultivo o producto', 'Documentacion organico', 'Recertificación', 0),
(92, 'Carta de certificación anterior o documento que contiene los requisitos, recomendaciones y/o condiciones', 'Documentacion organico', 'Recertificación', 0),
(93, 'Cuestionarios pertinentes a la certificación del cultivo o producto', 'Documentacion organico', 'Recertificación', 0),
(94, 'Informe de inspección en sitio(s)', 'Documentacion organico', 'Recertificación', 0),
(95, 'Historial de campo para los últimos 36 meses a partir de la fecha de la cosecha en que se recogió del sitio', 'Documentacion organico', 'Recertificación', 0),
(96, 'Mapas de campo para los últimos 36 meses a partir de la fecha de la cosecha e identificar el campo de la producción para el lote en cuestión\r\n', 'Documentacion organico', 'Recertificación', 0),
(97, 'Documentación que demuestre el tamaño el tamaño de la zona búfer entre la Producción Orgánica y la no orgánica\r\n', 'Documentacion organico', 'Recertificación', 0),
(98, 'Si la zona buffers son cosechadas, muestra de la documentación que compruebe la segregación de los cultivos orgánicos y de la zona de amortiguamiento', 'Documentacion organico', 'Recertificación', 0),
(99, ' La verificación de que el inspector es independiente de la operación y no tiene vínculos financieros con el solicitante. (Una declaración jurada es suficiente).', 'Documentacion organico', 'Recertificación', 0),
(100, 'Cantidad del cultivo o producto a ser aprobado', 'Documentacion organico', 'Recertificación', 0),
(101, ' Auditoría de seguimiento documental y comprobar cómo es manejado la segregación de los productos.', 'Documentacion organico', 'Recertificación', 0),
(102, 'Documentación relativa a la ubicación de lugar de almacenamiento de la cosecha o del producto', 'Documentacion organico', 'Recertificación', 0),
(103, 'Una descripción del Sistema de Control Interno (Si forma parte de un grupo de operadores)', 'Documentacion organico', 'Recertificación', 0),
(104, 'La documentación de los reglamentos internos(Si forma parte de un grupo de operadores)', 'Documentacion organico', 'Recertificación', 0),
(105, 'Comprobante de domicilio fiscal', 'Generales Productor', 'Generales Productor Mezcal', 0),
(106, 'Plano de distribución', 'Generales Productor', 'Generales Productor Mezcal', 0),
(107, 'Título de la marca (en caso de ser el propietario, este documento debe estar a nombre de la persona física o moral que se inscribe)', 'Marcas', 'Generales Comercializador', 0),
(108, 'CURP (en caso de ser persona física).\n', 'Generales Productor', 'Generales Productor', 0),
(109, 'INE del responsable de instalaciones', 'Generales Productor', 'Generales Productor', 0),
(110, 'INE del responsable de instalaciones', 'Generales Comercializador', 'Generales Comercializador1', 0),
(111, 'INE del responsable de instalaciones', 'Generales Envasador', 'Generales Envasador1', 0),
(112, 'Plano de distribución', 'Generales Comercializador', 'Generales Comercializador', 0),
(113, 'Comprobante de posesión de las instalaciones (si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento o comodato', 'Generales Productor', 'Generales Productor mezcal', 0),
(114, 'Copia de la identificación oficial vigente del arrendador y arrendatario (En caso de no ser propietario de las instalaciones)', 'Generales Productor', 'Generales Productor mezcal', 0),
(115, 'Evidencias', 'Documentacion organico', 'Evidencias', 0),
(116, 'FQ', 'Dictámenes', 'Dictamen', 0),
(117, 'Dictamen', 'Dictámenes', 'Dictamen', 0),
(118, 'Solicitud (Ingredientes ordenados)', 'Etiquetas', 'Alimentos', 0),
(119, 'Lista de aditivos', 'Etiquetas', 'Alimentos', 0),
(120, 'Medidas del producto', 'Etiquetas', 'Alimentos', 0),
(121, 'Declaración de uso de la marca', 'Marcas', 'Trámite', 0),
(122, 'BPM ( Buenas Prácticas de Manufactura)', 'Inspecciones', 'Instalaciones', 0),
(123, 'Instrumento de Evaluación', 'Inspecciones', 'Instalaciones', 0),
(124, 'Validación de la Información', 'Inspecciones', 'Instalaciones', 0),
(125, 'Informe de los Hallazgos', 'Inspecciones', 'Instalaciones', 0),
(126, 'Requisitos a evaluar NOM-070-SCFI-2016', 'Documentos generales', 'Todas', 0),
(127, 'Certificado de Instalaciones NOM productor', 'Generales Productor', 'Certificado', 0),
(128, 'Certificado de Instalaciones NOM envasador', 'Generales Envasador', 'Certificado', 0),
(129, 'Certificado de Instalaciones NOM comercializador', 'Generales Comercializador', 'Certificado', 0),
(132, 'Resultados de %ART', 'Generales Productor de agave', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `documentacion`
--
ALTER TABLE `documentacion`
  ADD PRIMARY KEY (`id_documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `documentacion`
--
ALTER TABLE `documentacion`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
