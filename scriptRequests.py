import mysql.connector
import requests
from bs4 import BeautifulSoup
from lxml import etree
from lxml import html
import pandas as pd
import time


mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="1234",
  database="carspecs_app"
)
queryBrand=mydb.cursor()
queryModel=mydb.cursor()
queryCombustible=mydb.cursor()
queryEtiqueta=mydb.cursor()




urlPaginaInicio = 'http://carspecs.desa.com/LoginController/login'
urlFormulario = 'http://carspecs.desa.com/AdminController/crearCoche'
urlCreacionModelo = 'http://carspecs.desa.com/AdminController/crearModelo'
infoInicioSesion={
    "loginUsername":"carlos",
    "loginPassword":"asd"
}

print('Creando objeto request')
Urls = ['https://www.auto-data.net/es/mercedes-benz-clk-a209-facelift-2005-amg-clk-dtm-5.5-v8-582hp-amg-speedshift-53139']
arrayCoches=[]
contador = 0
for url in Urls:
    print('bucle num ' + str(contador))
    print('redireccion a la pagina ' + url)
    driver=requests.get(url, verify=False)
    if driver.status_code==200 :
        print('obteniendo lal info de la pagina')
        html = driver.text
        auto_data_dom = BeautifulSoup( html,'lxml')
        print('Busquedas en el lxml')
        rutaHtml = auto_data_dom.find('img',{'class':'inspecs'})
        tabla = auto_data_dom.find('table',{'class':'car2'})
        ruta = 'https://www.auto-data.net/'+ rutaHtml['src']

        try:
            marca = tabla.find(string='Marca').findParent('tr').find('td').getText()
            modelo = str(tabla.find(string='Modelo ').findParent('tr').find('td').getText()).strip()
            versionRAW = tabla.find(string='Modificación (motor) ').findParent('tr').find('td').getText()
            if tabla.find(string='Consumo de combustible combinado '):
                consumoRAW = tabla.find(string='Consumo de combustible combinado ').findParent('tr').find('td').getText()
            elif tabla.find(string='Consumo de combustible urbano  '):
                consumoRAW = tabla.find(string='Consumo de combustible urbano  ').findParent('tr').find('td').getText()
            combustible = str(tabla.find(string='Combustible  ').findParent('tr').find('td').getText()).strip()
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

            print('Saco las id de los select')
            try:
                queryParamBrand="Select id_brand, brand from brands WHERE brand = %s"
                brandValue = (f"{marca}",)
                queryBrand.execute(queryParamBrand,brandValue)
                brand = queryBrand.fetchall()
                marcaId=brand[0][0]

            except Exception as e:
                print(e)

            print('Creo info modelo')
            infoCreacionModelo={
                "id_marca":marcaId,
                "inputModelo":modelo
            }

            try:
                print('inicio de sesion')
                inicioSesion = requests.post(urlPaginaInicio, data=infoInicioSesion,verify=False)
            except Exception as e:
                print(e)


            try:
                creacionModelo=requests.post(urlCreacionModelo, data=infoCreacionModelo, verify=False)
                mydb.close()
                mydb.connect()
                print('Creacion de modelo')
            except Exception as e:
                print(e)


            try:
                queryParamModel="Select id_model, model from models WHERE model = %s"
                modelValue = (f"{modelo}",)
                queryModel.execute(queryParamModel,modelValue)
                model = queryModel.fetchall()
                print(model)
                modeloId = model[0][0]
            except Exception as e:
                print(e)
                print('error query modelo')
            try:
                queryParamCombustible = "Select Id_combustible, CombustionType from combustibles WHERE CombustionType = %s"
                combustibleValue = (f"{combustible}",)
                queryCombustible.execute(queryParamCombustible,combustibleValue)
                combustibles = queryCombustible.fetchall()
                combustibleId=combustibles[0][0]
                print
            except Exception as e:
                print(e)
                print('error query combustible')

            infoFormulario={
                'marcaCrear':marcaId,
                'modeloCrear':modeloId,
                'versionCrear':version,
                'potenciaCrear':potencia,
                'consumoMedioCrear':consumo,
                'id_combustibleCrear':combustibleId,
                'torqueCrear':torque,
                'pesoCrear':peso,
                'rutaFotoCrear':ruta,
                'puntosSeguridadCrear':0,
                'likesCrear':0,
                'comprasCrear':0,
                'id_etiquetaCrear':1
            }
            print(infoFormulario)


            print('compruebo status de la peticion')
            try:
                submitFormulario=requests.post(urlFormulario, data=infoFormulario ,verify=False)
                print('hola')
            except Exception as e:
                print(e)
                print('peticion rechazada')


        except:
            print('Falta informacion en la Url proporcionada')
    else:
        print('Peticion rechazada')




exit()
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

