# ref
# ----------------------------------
# https://github.com/cjcliffe/CubicSDR/wiki/Build-Linux
apt update
apt-get install git -y build-essential automake cmake libpulse-dev libgtk-3-dev git librtlsdr-dev


# install SoapySDR
git clone https://github.com/pothosware/SoapySDR.git
cd SoapySDR
mkdir build
cd build
cmake ../ -DCMAKE_BUILD_TYPE=Release
make -j4
make install
ldconfig
SoapySDRUtil --info
cd ../..


# Build and install liquid-dsp
git clone https://github.com/jgaeddert/liquid-dsp
cd liquid-dsp
./bootstrap.sh
CFLAGS="-march=native -O3" ./configure --enable-fftoverride 
make -j4
make install
ldconfig
cd ../


# Build static wxWidgets:
wget https://github.com/wxWidgets/wxWidgets/releases/download/v3.1.1/wxWidgets-3.1.1.tar.bz2
tar -xvjf wxWidgets-3.1.1.tar.bz2
cd wxWidgets-3.1.1
mkdir -p ~/Develop/wxWidgets-staticlib
./autogen.sh 
./configure --with-opengl --disable-shared --enable-monolithic --with-libjpeg --with-libtiff --with-libpng --with-zlib --disable-sdltest --enable-unicode --enable-display --enable-propgrid --disable-webkit --disable-webview --disable-webviewwebkit --prefix=`echo ~/Develop/wxWidgets-staticlib` CXXFLAGS="-std=c++0x"
make -j4 && make install
cd ..


# Build CubicSDR
git clone https://github.com/cjcliffe/CubicSDR.git
cd CubicSDR
mkdir build
cd build
cmake ../ -DCMAKE_BUILD_TYPE=Release -DwxWidgets_CONFIG_EXECUTABLE=~/Develop/wxWidgets-staticlib/bin/wx-config
make
cd ../..


# SoapyRTLSDR (similar to other Soapy modules)
git clone https://github.com/pothosware/SoapyRTLSDR.git
cd SoapyRTLSDR
mkdir build
cd build
cmake .. -DCMAKE_BUILD_TYPE=Release
make
make install 
ldconfig
SoapySDRUtil --probe 
cd ../..


# SoapySDRPlay (similar to other Soapy modules):
git clone https://github.com/pothosware/SoapySDRPlay.git
cd SoapySDRPlay
mkdir build
cd build
cmake .. -DCMAKE_BUILD_TYPE=Release
make
make install
sudo ldconfig
SoapySDRUtil --probe
cd ../..





