pwd=$(pwd)

sudo apt-get update
sudo apt-get install build-essential git make cmake
cd $pwd
wget -O itpp-latest.tar.bz2 http://sourceforge.net/projects/itpp/files/latest/download?source=files
tar xjf itpp-latest.tar.bz2
cd itpp-4.3.1/
mkdir build && cd build
cmake ..
make -j
sudo make install
cd $pwd/
git clone https://github.com/szechyjs/mbelib.git
cd mbelib/
mkdir build && cd build
cmake ..
make
sudo make install
sudo apt-get install libsndfile1-dev fftw3-dev liblapack-dev portaudio19-dev
cd $pwd/
git clone https://github.com/szechyjs/dsd.git
cd dsd/
mkdir build && cd build
cmake ..
make
sudo make install


apt-get install alsa-oss
sudo modprobe snd_pcm_oss
sudo modprobe snd_mixer_oss
apt install socat

