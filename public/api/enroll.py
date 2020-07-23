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
    print('Connected to ' + connectPort)

else:
    print('Connection Issue!')


L=False
if len(sys.argv) > 1:
    who = sys.argv[1]
    L=True
    x="2"
    serials.write(x.encode())
    time.sleep(0.2)
    print (who)
while L:
    
    
    if os.path.exists('stop_script'):
        print("Exiting")
        sys.exit(0) 
    data = serials.readline().decode('ascii')
    if "Ready" in data:
        serials.write(who.encode())
    if "Remove finger" in data:
        print("Remove finger",flush=True)
        sys.exit(0) 
    if "Could not find fingerprint features" in data:
        print("Could not find fingerprint features",flush=True)
        sys.exit(0)
    # if "###" in data:
    #     break
    # print(data,flush=True)
sys.exit(0)