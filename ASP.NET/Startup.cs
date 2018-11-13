using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Hosting;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Logging;
using Microsoft.EntityFrameworkCore;
using DotNetCoreSqlDb.Models;

namespace DotNetCoreSqlDb
{
    public class Startup
    {
        public Startup(IConfiguration configuration)
        {
            Configuration = configuration;
        }

        public IConfiguration Configuration { get; }

        // This method gets called by the runtime. Use this method to add services to the container.
        public void ConfigureServices(IServiceCollection services)
        {
            // Add framework services.
            services.AddMvc();

            // Use Azure SQL and a connection string from the configuration.
            services.AddDbContext<DotNetCoreSqlDb.Models.MyDatabaseContext>(
                options =>
                    options.UseSqlServer(Configuration.GetConnectionString("MyDbConnection")));

            // Automatically update the database.
            services.BuildServiceProvider()
                .GetService<DotNetCoreSqlDb.Models.MyDatabaseContext>().Database.Migrate();

            // Use Azure SQL and a connection string from the configuration.
            services.AddDbContext<DotNetCoreSqlDb.Models.SenseHatContext>(
                options =>
                    options.UseSqlServer(Configuration.GetConnectionString("MyDbConnection")));

            // Automatically update the database.
            services.BuildServiceProvider()
                .GetService<DotNetCoreSqlDb.Models.SenseHatContext>().Database.Migrate();
        }

        // This method gets called by the runtime. Use this method to configure the HTTP request pipeline.
        public void Configure(IApplicationBuilder app, IHostingEnvironment env, ILoggerFactory loggerFactory)
        {
            loggerFactory.AddConsole(Configuration.GetSection("Logging"));
            loggerFactory.AddDebug();

            if (env.IsDevelopment())
            {
                app.UseDeveloperExceptionPage();
                app.UseBrowserLink();
            }
            else
            {
                app.UseExceptionHandler("/Home/Error");
            }

            app.UseStaticFiles();

            app.UseMvc(routes =>
            {
                routes.MapRoute(
                    name: "default",
                    template: "{controller=Todos}/{action=Index}/{id?}");

                routes.MapRoute(
                    name: "SenseHat",
                    template: "{controller=SenseHat}/{action=Index}/{id?}");
          

                /*routes.MapRoute(
                   name: "SenseHat",
                   template: "SenseHat/",
                   defaults: new { controller = "SenseHat", action = "Index" }
               );*/
            });
        }
    }
}
