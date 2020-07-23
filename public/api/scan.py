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
x="1"
serials.write(x.encode())
time.sleep(0.1)
while True:
   
    data = serials.readline().decode('ascii')
    # print(data)
    if "Found ID :" in data:
        print(data)
        sys.exit(0)
    elif "." in data:
        print("Fingerprint is busy, touch to reset",flush=True)
        time.sleep(1)
    elif "Did not find a match" in data:
        print ("Not Match")
        sys.exit(0)
    if os.path.exists('stop_script'):
        print("Exiting")
        sys.exit(0) 
    # print(data)
    # data = serials.readline().decode('ascii')
    # if "###" in data:
    #     x = "1"
    #     serials.write(x.encode())
    #     time.sleep(0.1)
    # elif "Found ID" in data:
    #     print(data,flush=True)
    #     sys.exit(0)
    # elif "Scanning" in data:
    #     print(data,flush=True)
    # elif "Did not find a match" in data:
    #     print("Mismatch",flush=True)
    #     sys.exit(0)
    # elif "Could not find fingerprint features" in data:
    #     print("Try Again",flush=True)
  