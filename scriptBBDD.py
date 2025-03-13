from selenium import webdriver
from bs4 import BeautifulSoup
from lxml import html
import time
import mysql.connector



mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="Qwer1234",
  database="carspecs_app"
)
queryBrand=mydb.cursor()
queryModel=mydb.cursor()
queryCombustible=mydb.cursor()
queryEtiqueta=mydb.cursor()
queryInsert=mydb.cursor()



driver = webdriver.Edge()
print('Creando objeto webdriver')
Urls = ['https://www.auto-data.net/es/seat-leon-i-1m-fr-1.9-tdi-150hp-13613']
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
        try:
            marca = tabla.find(string='Marca').findParent('tr').find('td').getText()
        except Exception as e:
            print(e)
            print('Falta informacion en la Url proporcionada1')
        
        try:
            modelo = tabla.find(string='Modelo ').findParent('tr').find('td').getText()
        except Exception as e:
            print(e)
            print('Falta informacion en la Url proporcionada2')
        try:
            versionRAW = tabla.find(string='Modificación (motor) ').findParent('tr').find('td').getText()
        except Exception as e:
            print(e)
            print('Falta informacion en la Url proporcionada3')
        try:
            if tabla.find(string='Consumo de combustible combinado '):
                consumoRAW = tabla.find(string='Consumo de combustible combinado ').findParent('tr').find('td').getText()
            elif tabla.find(string='Consumo de combustible urbano  '):
                consumoRAW = tabla.find(string='Consumo de combustible urbano  ').findParent('tr').find('td').getText()
        except Exception as e:
            print(e)
            print('Falta informacion en la Url proporcionada4')
        try:
            combustible = tabla.find(string='Combustible  ').findParent('tr').find('td').getText()
        except Exception as e:
            print(e)
            print('Falta informacion en la Url proporcionada5')
            
        try:
            torqueRAW = tabla.find(string='Par máximo  ').findParent('tr').find('td').getText()
        except Exception as e:
            print(e)
            print('Falta informacion en la Url proporcionada6')
            
        try:
            pesoRAW = tabla.find(string='Peso en orden de marcha ').findParent('tr').find('td').getText()
        except Exception as e:
            print(e)
            print('Falta informacion en la Url proporcionada7')
            
        try:
            potenciaRAW =tabla.find(string=' Potencia máxima ').findParent('tr').find('td').getText()
        except Exception as e:
            print(e)
            print('Falta informacion en la Url proporcionada8')
            
       
        
        

        

        
        
    except Exception as e:
        print(e)
        print('Falta informacion en la Url proporcionada')
        exit()
    print(marca)
    print('Dar formato a la informacion')
    ##Formatear
    indiceConsumo = consumoRAW.find('l/100') - 1
    consumo = consumoRAW[0:indiceConsumo]
    try:
        indiceTorque = torqueRAW.find('Nm') - 1
        torque = torqueRAW[0:indiceTorque]
    except Exception as e:
        torque = 0
    try:
        indicePeso = pesoRAW.find('kg') - 1
        peso = pesoRAW[0:indicePeso]
    except Exception as e:
        peso = 0


    indicePotencia = potenciaRAW.find('CV') - 1
    potencia = potenciaRAW[0:indicePotencia]
    version = versionRAW

    infoCoche = [marca, modelo, version, potencia, consumo, combustible, torque, peso, ruta]
    arrayCoches.append(infoCoche)
    contador += 1

    print('inicio insercion')

    try:
        queryParamBrand="Select id_brand, brand from brands WHERE brand = %s"
        brandValue = (f"{marca}",)
        queryBrand.execute(queryParamBrand,brandValue)
        brand = queryBrand.fetchall()
        marcaId=brand[0][0]

    except Exception as e:
        print(e)


    try:
        queryParamModel="Select id_model, model from models WHERE model = %s"
        modelValue = (f"{modelo}",)
        queryModel.execute(queryParamModel,modelValue)
        model = queryModel.fetchall()
        if not model:
            queryInsertModel = f"INSERT INTO models (id_brand, model) VALUES ({marcaId}, %s)"
            queryModel.execute(queryInsertModel,modelValue)
            mydb.commit()
            time.sleep(0.5)
            queryParamModel="Select id_model, model from models WHERE model = %s"
            modelValue = (f"{modelo}",)
            queryModel.execute(queryParamModel,modelValue)
            model = queryModel.fetchall()
            modeloId = model[0][0]
        else:
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
        
    except Exception as e:
        print(e)
        print('error query combustible')

    insert=f"INSERT INTO cars (id_brand, id_model,  version, horsePower, averageConsumption, id_combustible, engineTorque, weight, rutaFoto, safetyPoints, mostBought, likes, id_etiqueta) VALUES ({marcaId}, {modeloId}, '{version}', {potencia}, {consumo}, {combustibleId}, {torque}, {peso}, '{ruta}', 0, 0, 0, 4);"
    queryInsert.execute(insert)
  
    mydb.commit()









