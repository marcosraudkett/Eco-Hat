using System;
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Infrastructure;
using Microsoft.EntityFrameworkCore.Metadata;
using Microsoft.EntityFrameworkCore.Migrations;
using DotNetCoreSqlDb.Models;

namespace DotNetCoreSqlDb.Migrations
{
    [DbContext(typeof(SenseHatContext))]
    partial class SenseHatContextModelSnapshot : ModelSnapshot
    {
        protected override void BuildModel(ModelBuilder modelBuilder)
        {
            modelBuilder
                .HasAnnotation("ProductVersion", "1.1.2");

            modelBuilder.Entity("DotNetCoreSqlDb.Models.SenseHat", b =>
                {
                    b.Property<int>("Sense_hat_entry_id")
                        .ValueGeneratedOnAdd();

                    b.Property<DateTime>("Sense_hat_datetime");

                    b.Property<string>("Sense_hat_temperature");

                    b.Property<string>("Sense_hat_humidity");

                    b.Property<string>("Sense_hat_air_pressure");

                    b.HasKey("Sense_hat_entry_id");

                    b.ToTable("SenseHat");

                   
                });
        }
    }
}
