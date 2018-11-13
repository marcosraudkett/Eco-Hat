using System;
using System.Collections.Generic;
using Microsoft.EntityFrameworkCore.Metadata;
using Microsoft.EntityFrameworkCore.Migrations;

namespace DotNetCoreSqlDb.Migrations
{
    public partial class Initial : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            /*migrationBuilder.CreateTable(
                name: "SenseHat",
                columns: table => new
                {
                    Sense_hat_entry_id = table.Column<int>(nullable: false)
                    .Annotation("SqlServer:ValueGenerationStrategy",
                        Microsoft.EntityFrameworkCore.Metadata.SqlServerValueGenerationStrategy
                            .IdentityColumn),
                    Sense_hat_temperature = table.Column<string>(nullable: true),
                    Sense_hat_humidity = table.Column<string>(nullable: false),
                    Sense_hat_air_pressure = table.Column<string>(nullable: false),
                    Sense_hat_datetime = table.Column<DateTime>(nullable: false),
                },
                constraints: table =>
                {
                    table.PrimaryKey("Sense_hat_entry_id", x => x.Sense_hat_entry_id);
                });*/

            migrationBuilder.CreateTable(
                name: "Todo",
                columns: table => new
                {
                    ID = table.Column<int>(nullable: false)
                    .Annotation("SqlServer:ValueGenerationStrategy",
                        Microsoft.EntityFrameworkCore.Metadata.SqlServerValueGenerationStrategy
                            .IdentityColumn),
                    CreatedDate = table.Column<DateTime>(nullable: false),
                    Description = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_Todo", x => x.ID);
                });
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
           // migrationBuilder.DropTable(
            //    name: "SenseHat");

            migrationBuilder.DropTable(
                name: "Todo"); 
        }
    }
}
