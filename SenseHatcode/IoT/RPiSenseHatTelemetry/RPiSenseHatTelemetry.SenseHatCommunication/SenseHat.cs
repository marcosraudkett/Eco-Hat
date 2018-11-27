using System;
using System.Threading;
using System.Threading.Tasks;
using Emmellsoft.IoT.Rpi.SenseHat;
using RPiSenseHatTelemetry.Common;


namespace RPiSenseHatTelemetry.SenseHatCommunication
{
    public class SenseHat : IDisposable
    {
        private ISenseHat _senseHat { get; set; }

        // variable for unique id in database
        public int id_counter = 0;

        public async Task Activate()
        {
            _senseHat = await SenseHatFactory.GetSenseHat().ConfigureAwait(false);

            _senseHat.Display.Clear();
            _senseHat.Display.Update();
        }

        public TemperatureTelemetry GetTemperature()
        {
            while (true)
            {
                _senseHat.Sensors.HumiditySensor.Update();
                _senseHat.Sensors.PressureSensor.Update();

                if (_senseHat.Sensors.Humidity.HasValue)
                {
                    // increase unique id counter 
                    id_counter++;

                    return new TemperatureTelemetry()
                    {
                        

                        Sense_hat_datetime = DateTime.UtcNow.AddHours(3).ToString("yyyy-MM-dd HH:mm:ss.fff"),
                        Sense_hat_temperature = Math.Round(_senseHat.Sensors.Temperature.Value, 2),
                        Sense_hat_humidity = Math.Round(_senseHat.Sensors.Humidity.Value, 2),
                        Sense_hat_air_pressure = Math.Round(_senseHat.Sensors.Pressure.Value, 2),
                       // Sense_hat_entry_id = id_counter

                        // Time = DateTime.UtcNow.AddHours(3).ToString("yyyy-MM-dd HH:mm:ss.fff"),
                        // Temperature = Math.Round(_senseHat.Sensors.Temperature.Value, 2),
                        // Humidity = Math.Round(_senseHat.Sensors.Humidity.Value, 2)
                    };
                }

                else new ManualResetEventSlim(false).Wait(TimeSpan.FromSeconds(0.5));
            }
        }

        public HumidityTelemetry GetHumidity()
        {
            while (true)
            {
                _senseHat.Sensors.HumiditySensor.Update();

                if (_senseHat.Sensors.Humidity.HasValue)
                {
                    return new HumidityTelemetry()
                    {
                        Time = DateTime.UtcNow.AddHours(3).ToString("yyyy-MM-dd HH:mm:ss.fff"),
                        Humidity = Math.Round(_senseHat.Sensors.Humidity.Value, 2)

                   
                    };
                }

                else new ManualResetEventSlim(false).Wait(TimeSpan.FromSeconds(0.5));
            }
        }

        public PressureTelemetry GetPressure()
        {
            while (true)
            {
                _senseHat.Sensors.HumiditySensor.Update();

                if (_senseHat.Sensors.Pressure.HasValue)
                {
                    return new PressureTelemetry()
                    {
                        Time = DateTime.UtcNow.AddHours(3).ToString("yyyy-MM-dd HH:mm:ss.fff"),
                        Pressure = Math.Round(_senseHat.Sensors.Pressure.Value, 2)


                    };
                }

                else new ManualResetEventSlim(false).Wait(TimeSpan.FromSeconds(0.5));
            }
        }

        public void Dispose()
        {
            _senseHat.Dispose();
        }

        public async void ScreenControl()
        {
            int i;
            for (i = 0; i <3; i++)
            {
                _senseHat.Display.Reset();
                _senseHat.Display.Update();
                await Task.Delay(250);
                _senseHat.Display.Clear();
                _senseHat.Display.Update();
                await Task.Delay(250);
            }
        }

    }
}
