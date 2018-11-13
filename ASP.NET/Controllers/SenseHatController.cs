using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using DotNetCoreSqlDb.Models;

namespace DotNetCoreSqlDb.Controllers
{
    public class SenseHatController : Controller
    {
        private readonly SenseHatContext _context;

        public SenseHatController(SenseHatContext context)
        {
            _context = context;    
        }

        // GET: SenseHat Data
        public async Task<IActionResult> Index()
        {
            /* sorting */
            IQueryable<SenseHat> SenseHat_ = from s in _context.SenseHat
                                             select s;
            var SenseHat = SenseHat_.OrderBy(s => s.Sense_hat_entry_id);

            //var SenseHat = from d in dbo.tbl_TRELEC_Tax_ETV orderby d.Start_date descending select d;

            return View(await _context.SenseHat.ToListAsync());
            //return View(await _context.SenseHat.ToListAsync());
        }

        // GET: SenseHat/Details/5
        public async Task<IActionResult> Details(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var sensehat = await _context.SenseHat
                .SingleOrDefaultAsync(m => m.Sense_hat_entry_id == id);
            if (sensehat == null)
            {
                return NotFound();
            }

            return View(sensehat);
        }

        // POST: SenseHat/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> DeleteConfirmed(int id)
        {
            var todo = await _context.SenseHat.SingleOrDefaultAsync(m => m.Sense_hat_entry_id == id);
            _context.SenseHat.Remove(todo);
            await _context.SaveChangesAsync();
            return RedirectToAction("Index");
        }

        private bool TodoExists(int id)
        {
            return _context.SenseHat.Any(e => e.Sense_hat_entry_id == id);
        }
    }
}