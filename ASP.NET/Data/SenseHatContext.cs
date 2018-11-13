using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.EntityFrameworkCore;

namespace DotNetCoreSqlDb.Models
{
    public class SenseHatContext : DbContext
    {
        public SenseHatContext(DbContextOptions<SenseHatContext> options)
            : base(options)
        {
        }

        public DbSet<DotNetCoreSqlDb.Models.SenseHat> SenseHat { get; set; }
    }
}
