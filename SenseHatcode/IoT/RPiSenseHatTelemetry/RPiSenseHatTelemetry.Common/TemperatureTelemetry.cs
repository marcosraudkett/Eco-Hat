using System;

namespace RPiSenseHatTelemetry.Common
{
    public class TemperatureTelemetry
    {
        public string Sense_hat_datetime { get; set; }

        public double Sense_hat_temperature { get; set; }

        public double Sense_hat_humidity { get; set; }

       // public int Sense_hat_entry_id { get; set; }

        public double Sense_hat_air_pressure { get; set; }
    }
}
