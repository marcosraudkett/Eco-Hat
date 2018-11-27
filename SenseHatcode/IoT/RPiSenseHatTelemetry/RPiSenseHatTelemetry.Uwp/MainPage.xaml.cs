using System;
using RPiSenseHatTelemetry.SenseHatCommunication;
using Windows.UI.Xaml.Controls;
using Windows.UI.Xaml;
using RPiSenseHatTelemetry.CloudCommunication;
using Newtonsoft.Json;

namespace RPiSenseHatTelemetry.Uwp
{

    public sealed partial class MainPage : Page
    {
        private SenseHat _senseHat { get; set; }
        private IoTHubConnection _iotHubConnection { get; set; }

        

        public MainPage()
        {
            this.InitializeComponent();

            _senseHat = new SenseHat();
            _iotHubConnection = new IoTHubConnection();

            this.ActivateSenseHat();

            this.Loaded += (sender, e) =>
            {
                DispatcherTimer timer = new DispatcherTimer();

                timer.Tick += async (x, y) =>
                {

                  
                    // Just to show temperature on device screen
                    var temperatureTelemetry = _senseHat.GetTemperature();
                    this.temperatureTextBlock.Text = "Temperature: " + temperatureTelemetry.Sense_hat_temperature.ToString();

                    // send temperature, time, pressure and humidity to cloud
                    await _iotHubConnection.SendEventAsync(JsonConvert.SerializeObject(temperatureTelemetry));


                    // Just to show humidity value on device screen
                    var humidityTelemetry = _senseHat.GetHumidity();
                   this.humidityTextBlock.Text = "Humidity: " + humidityTelemetry.Humidity.ToString();

                    // Just to show pressure value on device screen
                    var pressureTelemetry = _senseHat.GetPressure();
                    this.pressureTextBlock.Text = "Pressure: " + pressureTelemetry.Pressure.ToString();

                    _senseHat.ScreenControl();

                };

                timer.Interval = TimeSpan.FromSeconds(30);
                timer.Start();
            };
        }

        private async void ActivateSenseHat()
        {
           await _senseHat.Activate();
        }
    }
}
