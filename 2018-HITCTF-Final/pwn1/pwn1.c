#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <fcntl.h>
#include <string.h>

char s[0x60];
char *name = s;
char *IDNumber = &s[0x30];
int login_status;
int *cookie = (int *)&s[0x50];


void init();
void menu();
void reg();
void login();
void reset();
void logout();

int main()
{
	int choice;
	
	init();

	while(1)
	{
		menu();
		scanf("%d", &choice);
		switch(choice)
		{
			case 1:
				reg();
				break;
			case 2:
				login();
				break;
			case 3:
				reset();
				break;
			case 4:
				logout();
				break;
			case 5:
				printf("Bye~\n");
				exit(0);
				break;
			default:
				printf("Invalid choice.\n");
				break;
		}
	}
	return 0;
}

void init()
{
	int fd;

	setvbuf(stdout,NULL,_IONBF,0);
	setvbuf(stdin,NULL,_IONBF,0);
	fd = open("/dev/urandom", O_RDONLY);
	if(fd < 0)
		exit(1);

	read(fd, (void *)(cookie), 6);
	printf("Input your name:\n");
	read(0, name, 0x28);
	printf("Input the last six numbers of your ID card:\n");
	read(0, IDNumber, 0x28);
	printf("Init cookie...\n");

	login_status = 1;
	sleep(1);
	printf("Login success!\n");
	//printf("your cookie is: %d\n", cookie);
	close(fd);
}

void menu()
{
	puts("1.register");
	puts("2.login");
	puts("3.reset ID number");
	puts("4.logout");
	puts("5.exit");
	printf("Your choice:");

}

void reg()
{
	if(login_status)
	{
		printf("Already logined!\n");
		return;
	}

	printf("Input your name:\n");
	read(0, name, 0x20);
	printf("Input the last six numbers of your ID card:\n");
	read(0, IDNumber, 0x20);
	printf("Register success.\n");
}

void login()
{
	char name1[0x28];
	char id_n[0x28];
	if(login_status)
	{
		printf("Already logined!\n");
		return;
	}
	memset(name1, 0x00, 0x28);
	memset(id_n, 0x00, 0x28);
	printf("name:\n");
	int len1 = read(0, name1, 0x28);
	printf("Last six numbers of your ID card:\n");
	int len2 = read(0, id_n, 0x28);
	if(!strncmp(name1, name, len1) && !strncmp(id_n, IDNumber, len2))
	{
		printf("Hello %s\n", name);
		login_status = 1;
	}
	else{
		printf("Invalid name or ID number.\n");
	}
}

void reset()
{
	char ch[0x20];
	int  ck;
	if(!login_status)
	{
		printf("Login first.\n");
		return;
	}

	printf("Do you want to change your ID number?\n");
	getchar();
	gets(ch);
	if(*ch == 'y' || *ch == 'Y')
	{
		printf("Input your cookie:\n");
		scanf("%d", &ck);
		if(ck == *cookie)
		{
			printf("Your name:\n");
			printf(name);
			printf("\nYour old ID number:\n");
			printf("*********\n");
			printf("Input your new ID number:\n");
			read(0, IDNumber, 0x28);
		}
		else
		{
			printf("Error cookie.\n");
		}
	}
}

void logout()
{
	login_status = 0;
	printf("logout~\n");
}