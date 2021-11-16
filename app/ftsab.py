# -*- coding: utf-8 -*-
"""
Created on Fri Jan 15 15:27:51 2021

@author: Yusuf Dwi Putra
"""
import mysql.connector
import pandas as pd
import numpy as np
from datetime import date
import json
from datetime import date
# koneksi ke db

mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="db_tbs_ftsab"
)
# ambil data dari db
mycursor = mydb.cursor()
mycursor.execute("SELECT * FROM datasets ")
myresult = mycursor.fetchall()
# data =  (sys.argv[1])



# pindah ke array
tbs = []
tanggal = []
for row in myresult:
    tanggal.append(row[1])
    tbs.append(row[2])

    # Convert ke format waktu Y-m-d
def Date_Converter(Date):
    return date.strftime(Date,"%Y-%m-%d")
new_tanggal = [Date_Converter(d) for d in tanggal]





minimum_tbs = np.min(tbs)
maximum_tbs = np.max(tbs)
#normalisasi
tbs_normalisasi = (tbs - minimum_tbs)/(maximum_tbs-minimum_tbs) * (5-1)+1

#selisih absolut
selisih_absolut = []
i = 0
for x in tbs_normalisasi:
    
    if(i < len(tbs_normalisasi)-1):
        e = abs(tbs_normalisasi[i+1]-tbs_normalisasi[i])
        selisih_absolut.append(e)
        i+=1
    else:
        break


 
minimum = np.min(tbs_normalisasi)
maximum = np.max(tbs_normalisasi)

# a. Hitung rata-rata selisih
S = np.mean(selisih_absolut)

#b. ambil 1/2 rata-rata selisih

R = 0.5*S

#c. Tentukan basis interval nilai pada langkah b, berdasarkan aturan xihao yimin

if(0.1<=R<=1):
    basis = 0.1
if(1.1<=R<=10):
    basis = 1
if(11<=R<=100):
    basis = 10
if(101<=R<=1000):
    basis = 100
    
#d. Membulatkan panjang dari hasil langkah b
I = round(R/basis)*basis


    

#menentukan batas bawah dan batas atas awal

batas_atas = []
batas_bawah = []
nilai_tengah = []
i = 1
bawah = minimum
atas = minimum

while (i<=len(selisih_absolut)):
    
    bawah = atas
   
    batas_bawah.append(bawah)
    
    atas = bawah+I
    batas_atas.append(atas)
    
    tengah = float((bawah+atas)/2)
    nilai_tengah.append(tengah)
    i+=1
    if(atas >= maximum):
        break;
# nilai_tengah = pd.DataFrame(nilai_tengah)


#    
##============================================================================
##Mendefinisikan Himpunan Fuzzy 
##============================================================================
    
himpunan_fuzzy = []
i = 1
for x in batas_bawah: 
    j = 1
    for y in batas_bawah:
        if ((i-j) == 0):
            himpunan_fuzzy.append(1)
            
        elif ((i-j) == 1 or(i-j) == -1 ):
            himpunan_fuzzy.append(0.5)
        
        else:
            himpunan_fuzzy.append(0)
            
        j+=1
    i+=1



# ##============================================================================
# ## Mendefinisikan Nilai Linguistik Himpunan Fuzzy 
# ##============================================================================
# ##    21 nilai linguistik 
# #linguistik = [
# #        'Sangat-sangat turun drastis sekali',
# #        'Sangat turun drastis sekali',
# #        'Sangat turun drastis',
# #        'Turun drastis',
# #        'Sangat-sangat turun sekali',
# #        'Sangat turun sekali',
# #        'Turun sekali',
# #        'Cukup turun',
# #        'Turun',
# #        'Sedikit turun',
# #        'Tetap',
# #        'Sedikit naik',
# #        'Naik',
# #        'Cukup naik',
# #        'Naik sekali',
# #        'Sangat naik sekali',
# #        'Sangat-sangat naik sekali',
# #        'Naik drastis',
# #        'Sangat naik drastis',
# #        'Sangat naik drastis sekali',
# #        'Sangat-sangat naik drastis sekali'
# #        ]
# #
# #l_sbb = len(new_batas_bawah)
# #l_ling = len(linguistik)
# #l_get = 0
# #if (l_sbb % 2 == 0): # jika panjang baris ganjil
# #    del linguistik[10] # hapus value tetap
# #    
# #l_get = (l_ling-l_sbb)/2
# #  
# #l_getNew = round(l_get)
# #
# #
# #i = 0
# #
# #get_nilai_linguistik = []
# #while (i < l_sbb):
# #    get_nilai_linguistik.append(linguistik[l_getNew])
# #    l_getNew+=1
# #    i+=1
# #    
# #print("\nNILAI LINGUISTIK",get_nilai_linguistik)
#
##============================================================================
##Fuzzyfikasi dan Relasi Logika Fuzzy
##============================================================================
fuzzifikasi = []

for x in tbs_normalisasi:
    j = 1
    for y in batas_atas:
        if (x <= y):
            fuzzifikasi.append("A " + str(j))
            break;
        
        j+=1   

#print ("\nFUZZIFIKASI",fuzzifikasi)
#        
#menentukan FLR & FLRG
FLR = []
FLRG = []

i = 0
for x in fuzzifikasi:
    try:
        FLR.insert(i, str(x)+"->"+str(fuzzifikasi[i+1]))
        j = 1
        for y in batas_bawah:    
            if (str(fuzzifikasi[i]) == 'A '+str(j)):
                FLRG.insert(i+1, 'G'+str(j))
            j+=1
        
    except:
        FLR.insert(i, str(x)+"->"+'0 0')
        break;
    i+=1


FLRG_list = pd.DataFrame(FLR)
now_FLRG_list = FLRG_list.groupby(by=0).size().reset_index(name='counts')
#

#
##============================================================================
##Pembobotan
##============================================================================
#
# membuat label horizontal
label_h = []
peramalan = [] 
count_of_flr = []
j = 1
for x in batas_bawah:
    label_h.append("A "+str(j))
    peramalan.append([])
    count_of_flr.append([])
    j+=1

# fungsi split kata
def split(word):
        return list(word)

j = 0
for y in now_FLRG_list[0]:
    split_flr = y.split("->")
    Ai = split_flr[0].split(" ")
    Aj = split_flr[1].split(" ")
    
    if(Aj[1] != '0'):
        mj = nilai_tengah[(int(Aj[1])-1)]
  
        
    
#    mencari entitas pada flrg
    n_flrg = now_FLRG_list['counts'][j]
    peramalan[int(Ai[1])-1].append(float(mj)*float(n_flrg))
    
    # mencari jumlah dari flr
    count_of_flr[int(Ai[1])-1].append(n_flrg)

    j+=1

#perhitungan nilai peramalan
peramalan_now = []
i = 0
for x in peramalan:
    y = sum(x)/sum(count_of_flr[i])
    peramalan_now.append(y)
    i+=1

##============================================================================
## Menghitung Nilai PREDIKSI
##============================================================================

prediksi = []
prediksi.append(0)
i = 0
for x in fuzzifikasi:
    try:
        split_flr = FLR[i].split("->")
        Ai = split_flr[0].split(" ")
        Aj = split_flr[1].split(" ")
        j = 0
        for y in peramalan_now:
            if (x == label_h[j]):
                prediksi.append(y)
                break
            
            j+=1
        i+=1
    except:
       print('')



##============================================================================
## Menghitung Nilai MAPE
##============================================================================
#
mape = []

i = 1
for x in tbs_normalisasi:
    try:
        if (x != 0):
            e = abs((tbs_normalisasi[i]-prediksi[i])/tbs_normalisasi[i])
            mape.append(e)
        else:
            mape.append(0)
        i+=1
    except:
        break
# Menghitung MAPE
avg_mape = (np.mean(mape))*100

# print("MAPE PREDIKSI: ",avg_mape,"%")

## get nilai prediksi selanjutnya
get_next_predict = prediksi[-1]
prediksi_next = round((((get_next_predict-1) * (maximum_tbs-minimum_tbs))/(5-1))+minimum_tbs)
 
arr = {
    'avg_mape' : avg_mape,
    'prediksi_next' : prediksi_next,
    'tbs_normalisasi' : tbs_normalisasi.tolist(),
    'prediksi' : prediksi,
    
}

xx = json.dumps(arr)

print (xx)  

##============================================================================
## Membuat chart data aktual dan prediksi
##============================================================================
#
#print(kelompok.index.tolist())
#
##plt.figure(figsize=(20,8))
##x = kelompok.index
##y = nilai
##z = prediksi
##plt.plot(x,y, color = 'blue') # nilai aktual
##plt.plot(x,z, color = 'red') # nilai prediksi
### tampilan
##plt.title('Nilai Prediksi Hotspot di Provinsi Riau')
##plt.xlabel('blue = nilai aktual red = nilai prediksi')
##plt.ylabel('Jumlah kejadian')
##plt.gcf().autofmt_xdate()
##
##plt.show()
#
