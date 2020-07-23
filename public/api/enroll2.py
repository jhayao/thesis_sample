import serial
import time
import serial.tools.list_ports
import os, sys
def get_ports():
    ports = serial.tools.list_ports.comports()
    return ports
def findArduino(portsFound):
    commPort = 'None'
    numConnection = len(portsFound)
    for i in range(0,numConnection):
        port = foundPorts[i]
        strPort = str(port)
        if 'Arduino' in strPort or  'CH340' in strPort: 
            splitPort = strPort.split(' ')
            commPort = (splitPort[0])
    return commPort
            
                    
foundPorts = get_ports()        
connectPort = findArduino(foundPorts)
if connectPort != 'None':
    serials = serial.Serial(connectPort,baudrate = 9600, timeout=1)
    # print('Connected to ' + connectPort)

else:
    print('Connection Issue!')
L=False

L2=True
while L2:
    data = serials.readline().decode('ascii')
    if "scanning" in data:
        L=True
        L2=False
    

while L:
    
    
    if os.path.exists('stop_script'):
        print("Exiting")
        sys.exit(0) 
    data = serials.readline().decode('ascii')
    if "Scanning" in data:
        # print("Remove finger")
        sys.exit(0) 
    if "###" in data:
        break
    if "Stored" in data:
        print(data,flush=True)
        break
    # print(data)
sys.exit(0)