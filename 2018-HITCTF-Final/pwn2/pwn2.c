#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <fcntl.h>
#include <string.h>
#include <time.h>

void init();
void menu();
void add();
void edit();
void show();
void delete();
int get_int();

struct message
{
	char title[8];
	char name[8];
	time_t time;
	char * content;
	int content_size;
};

typedef struct message msg;

msg *list[16];

void main()
{
	int choice;
	init();
	while(1)
	{
		menu();
		//scanf("%d", &choice);
		choice = get_int();
		switch(choice)
		{
			case 1:
				add();
				break;
			case 2:
				edit();
				break;
			case 3:
				show();
				break;
			case 4:
				delete();
				break;
			case 5:
				exit(0);
				break;
			default:
				printf("Invalid choice.\n");
				break;
		}
	}

}

void init()
{
	setvbuf(stdout,NULL,_IONBF,0);
	setvbuf(stdin,NULL,_IONBF,0);
}

void menu()
{
	printf("1.Leave message.\n");
	printf("2.Edit message.\n");
	printf("3.Show message.\n");
	printf("4.Delete message.\n");
	printf("5.Exit.\n");
	printf("Input your choice:");
}

int get_int()
{
	char i[0x20];
	read(0, i, 0x20);
	return atoi(i);
}

void add()
{
	int i = 0;
	while(list[i] != NULL && i < 16)
		i++;

	if(i > 15)
	{
		printf("Full.\n");
		return;
	}
	list[i] = (msg *)malloc(sizeof(msg));
	//printf("size: %u\n", *(unsigned int *)(((unsigned char *)list[i]) - 8));
	printf("title:\n");
	read(0, list[i]->title, 8);
	printf("name:\n");
	read(0, list[i]->name, 8);
	//printf("time:\n");
	list[i]->time = time(NULL);
	//printf("%ld\n", list[i]->time);
	
	do{
		printf("message size:\n");
		list[i]->content_size = get_int();
	}
	while(list[i]->content_size <= 0 || list[i]->content_size >= 0x100);
	
	list[i]->content = (char *)malloc(list[i]->content_size + 1);
	printf("message:\n");
	read(0, list[i]->content, list[i]->content_size);
}

void edit()
{

	int size, index;
	printf("Which one?\n");
	index = get_int();
	if(index < 0 || index >= 16)
	{	
		printf("out of bound.\n");
		return;
	}
	if(list[index] == NULL)
	{
		printf("message doesn't exist.\n");
		return;
	}
	
	do
	{
		printf("message size:\n");
		size = get_int();
	}
	while(size <= 0 || size >= 0x100);

	if(size != list[index]->content_size)
		list[index]->content = (char *)realloc(list[index]->content, size + 1);
	
	printf("new message:\n");
	read(0, list[index]->content, list[index]->content_size);
}

void show()
{
	
	printf("Which one?\n");
	int index = get_int();
	if(index < 0 || index >= 16)
	{	
		printf("out of bound.\n");
		return;
	}
	if(list[index] == NULL)
	{
		printf("message doesn't exist.\n");
		return;
	}
	printf("Title: %s\nName: %s\ntime: %ld\nContent: %s\n", list[index]->title, list[index]->name, list[index]->time, list[index]->content);
	
}

void delete()
{
	printf("Which one?\n");
	int index = get_int();
	if(index < 0 || index >= 16)
	{	
		printf("out of bound.\n");
		return;
	}
	if(list[index] == NULL)
	{
		printf("message doesn't exist.\n");
		return;
	}

	free(list[index]->content);
	free(list[index]);
	list[index] = NULL;
	printf("delete~.\n");
}