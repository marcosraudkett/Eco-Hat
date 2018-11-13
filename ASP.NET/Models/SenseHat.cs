using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace DotNetCoreSqlDb.Models
{
    public class SenseHat
    {
        [Key]
        public int Sense_hat_entry_id { get; set; }
        public double Sense_hat_temperature { get; set; }
        public double Sense_hat_humidity { get; set; }
        public double Sense_hat_air_pressure { get; set; }

        [Display(Name = "Created Date")]
        [DataType(DataType.Date)]
        [DisplayFormat(DataFormatString = "{0:yyyy-MM-dd}", ApplyFormatInEditMode = true)]
        public DateTime Sense_hat_datetime { get; set; }
    }
}
