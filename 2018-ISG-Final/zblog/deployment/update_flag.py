import sys

flag_path = "/flag"

def update(flag):
    with open(flag_path, "w") as f:
        f.write(flag)

def main():
    if len(sys.argv) != 2:
        print("[-] Please provide flag as argv[1]")
        exit(1)
    flag = sys.argv[1]
    update(flag)
    print("[+] Flag updated, new flag: %s" % (open(flag_path).read()))

if __name__ == "__main__":
    main()

