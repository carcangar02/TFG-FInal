from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from bs4 import BeautifulSoup
from lxml import etree
from lxml import html
import pandas as pd
import time



urlPagina = 'http://carspecs.desa.com/'
driver = webdriver.Edge()
print('Creando objeto webdriver')
Urls = ['https://www.auto-data.net/es/mercedes-benz-clk-a209-facelift-2005-amg-clk-dtm-5.5-v8-582hp-amg-speedshift-53139']
arrayCoches=[]
contador = 0
for url in Urls:
    print('bucle num ' + str(contador))
    print('redireccion a la pagina ' + url)
    driver.get(url)
    print('obteniendo lal info de la pagina')
    html = driver.page_source
    auto_data_dom = BeautifulSoup( html,'lxml')
    print('Busquedas en el lxml')
    rutaHtml = auto_data_dom.find('img',{'class':'inspecs'})
    tabla = auto_data_dom.find('table',{'class':'car2'})
    ruta = 'https://www.auto-data.net/'+ rutaHtml['src']

    try:
        marca = tabla.find(string='Marca').findParent('tr').find('td').getText()
        modelo = tabla.find(string='Modelo ').findParent('tr').find('td').getText()
        versionRAW = tabla.find(string='Modificación (motor) ').findParent('tr').find('td').getText()
        if tabla.find(string='Consumo de combustible combinado '):
            consumoRAW = tabla.find(string='Consumo de combustible combinado ').findParent('tr').find('td').getText()
        elif tabla.find(string='Consumo de combustible urbano  '):
            consumoRAW = tabla.find(string='Consumo de combustible urbano  ').findParent('tr').find('td').getText()
        combustible = tabla.find(string='Combustible  ').findParent('tr').find('td').getText()
        torqueRAW = tabla.find(string='Par máximo  ').findParent('tr').find('td').getText()
        pesoRAW = tabla.find(string='Peso en orden de marcha ').findParent('tr').find('td').getText()
        potenciaRAW =tabla.find(string=' Potencia máxima ').findParent('tr').find('td').getText()

        print('Dar formato a la informacion')
        ##Formatear
        indiceConsumo = consumoRAW.find('l/100') - 1
        consumo = consumoRAW[0:indiceConsumo]

        indiceTorque = torqueRAW.find('Nm') - 1
        torque = torqueRAW[0:indiceTorque]

        indicePeso = pesoRAW.find('kg') - 1
        peso = pesoRAW[0:indicePeso]

        indicePotencia = potenciaRAW.find('CV') - 1
        potencia = potenciaRAW[0:indicePotencia]

        indiceVersion = versionRAW.find('(')
        mitad1Version = versionRAW[0:indiceVersion]
        mitad2Version = versionRAW[indiceVersion + 8:]
        version = mitad1Version + " " + mitad2Version

        infoCoche = [marca, modelo, version, potencia, consumo, combustible, torque, peso, ruta]
        arrayCoches.append(infoCoche)
        contador += 1

        print('inicio insercion')

        print('creacion objeto Webdriver a mi pagina')
        miPagina = webdriver.Edge()

        print('entro en la pagina')
        miPagina.get(urlPagina)

        print('Ingreso en inicio de sesion')
        miPagina.find_element(By.CLASS_NAME, 'btnLogin0').click()
        print('inicio sesion')
        miPagina.find_element(By.NAME, 'loginUsername').send_keys('carlos')
        miPagina.find_element(By.NAME, 'loginPassword').send_keys('asd')
        miPagina.find_element(By.ID, 'iniciarSesion').click()
        print('entro en la gestion de coches')
        miPagina.find_element(By.ID, 'Gestion de coches').click()
        print('se crea el modelo')
        miPagina.find_element(By.ID, 'crearModeloModal').click()
        time.sleep(1.5)
        miPagina.find_element(By.ID, 'crearModeloInput').send_keys(str(modelo).strip())
        modeloMarcaId = Select(miPagina.find_element(By.ID, 'crearModeloIdMarca'));
        modeloMarcaId.select_by_visible_text(str(marca).strip())
        miPagina.find_element(By.ID, 'btnCrearModelo').click()
        print('modelo creado')
        miPagina.refresh();
        print('abro el modal')
        miPagina.find_element(By.ID, 'botonCrearCoche').click()
        time.sleep(1.5)
        print('Selecciono la marca')

        try:
            time.sleep(0.5)
            marcasInput = Select(miPagina.find_element(By.NAME, 'marcaCrear'))
            marcasInput.select_by_visible_text(str(marca).strip())
        except:
            print('la marca no existe, se crea')
            miPagina.find_element(By.ID, 'crearMarcaModal').click()
            time.sleep(1)
            miPagina.find_element(By.ID, 'crearMarcaInput').send_keys(str(marca).strip())
            miPagina.find_element(By.ID, 'btnCrearMarca').click()
            print('marca creada')
        print('Selecciono el modelo')

        time.sleep(0.3)
        marcasInput = Select(miPagina.find_element(By.NAME, 'modeloCrear'));
        marcasInput.select_by_visible_text(str(modelo).strip())

        marcasInput = Select(miPagina.find_element(By.NAME, 'id_combustibleCrear'));
        marcasInput.select_by_visible_text(str(combustible).strip())

        marcasInput = Select(miPagina.find_element(By.NAME, 'id_etiquetaCrear'));
        marcasInput.select_by_visible_text('No')

        miPagina.find_element(By.NAME, 'versionCrear').send_keys(version)
        miPagina.find_element(By.NAME, 'consumoMedioCrear').send_keys(consumo)
        miPagina.find_element(By.NAME, 'potenciaCrear').send_keys(potencia)
        miPagina.find_element(By.NAME, 'torqueCrear').send_keys(torque)
        miPagina.find_element(By.NAME, 'pesoCrear').send_keys(peso)
        miPagina.find_element(By.NAME, 'likesCrear').send_keys(0)
        miPagina.find_element(By.NAME, 'puntosSeguridadCrear').send_keys(0)
        miPagina.find_element(By.NAME, 'comprasCrear').send_keys(0)
        miPagina.find_element(By.NAME, 'rutaFotoCrear').send_keys(str(ruta).strip())

        miPagina.find_element(By.ID, 'btnCrearCoche').click()
        miPagina.quit()
    except:
        print('Falta informacion en la Url proporcionada')





print('fuera del bucle')
marcas = []
modelos = []
versiones = []
potencias = []
consumos = []
combustibles = []
torques = []
pesos = []
rutas=[]

print('organizacion de la info')
for coche in arrayCoches:
    marcas.append(str(coche[0]))
    modelos.append(str(coche[1]))
    versiones.append(str(coche[2]))
    potencias.append(str(coche[3]))
    consumos.append(str(coche[4]))
    combustibles.append(str(coche[5]))
    torques.append(str(coche[6]))
    pesos.append(str(coche[7]))
    rutas.append(str(coche[8]))

print('creacion del futuro excel')
arrayExcel={
    'marca':marcas,
    'modelo':modelos,
    'version':versiones,
    'potencia':potencias,
    'consumo':consumos,
    'combustible':combustibles,
    'torque':torques,
    'peso':pesos,
    'ruta':rutas
}

print('creacion del excel')
dataframe = pd.DataFrame(arrayExcel)
dataframe.to_excel('./cars.xlsx')