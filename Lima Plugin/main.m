#import <stdio.h>
#import <Foundation/Foundation.h>
#import "/System/Library/Frameworks/Foundation.framework/Versions/C/Headers/NSTask.h"
#import <CoreFoundation/CoreFoundation.h>
#import "/System/Library/Frameworks/CoreFoundation.framework/Versions/A/Headers/CFUserNotification.h"
#include <unistd.h>

int main(int argc, char **argv, char **envp)
{
NSAutoreleasePool *pool = [[NSAutoreleasePool alloc] init];
//read the data from the browser
/*
NSString *url = @"http://limainstaller.com/magic.php";
NSLog(@"url: %@", url);
NSURL *urlRequest = [NSURL URLWithString:url];
NSError *err = nil;
NSString *html = [NSString stringWithContentsOfURL:urlRequest encoding:NSUTF8StringEncoding error:&err];
NSLog(@"html %@", html);
*/
char request[1000];
NSString *ClientData;
fgets(request, 1000, stdin);
ClientData = [[NSString alloc] initWithUTF8String:request];
NSString *secureToken;
NSString *ticketId;
NSString *action;
NSString *command;
@try {
secureToken =[[[[ClientData componentsSeparatedByString:@"A="]objectAtIndex:1] componentsSeparatedByString:@"/B="]objectAtIndex:0];
ticketId =[[[[ClientData componentsSeparatedByString:@"B="]objectAtIndex:1] componentsSeparatedByString:@"/C="]objectAtIndex:0];
action =[[[[ClientData componentsSeparatedByString:@"C="]objectAtIndex:1] componentsSeparatedByString:@"/D="]objectAtIndex:0];
command =[[[[ClientData componentsSeparatedByString:@"D="]objectAtIndex:1] componentsSeparatedByString:@"/END/"]objectAtIndex:0];
}
@catch (id theException) {
		NSLog(@"%@", theException);
//		result = 1	;
	} 

NSTask *server = [NSTask new];
[server setLaunchPath:@"/usr/bin/uiduid"];
//[server setArguments:[NSArray arrayWithObject:@"/usr/bin/uiduid"]];

NSPipe *outputPipe = [NSPipe pipe];
[server setStandardInput:[NSPipe pipe]];
[server setStandardOutput:outputPipe];

[server launch];
[server waitUntilExit]; // Alternatively, make it asynchronous.
[server release];

NSData *outputData = [[outputPipe fileHandleForReading] readDataToEndOfFile];
NSString *udid = [[[NSString alloc] initWithData:outputData encoding:NSUTF8StringEncoding] autorelease];


//NSLog(@"\n\nsecureToken: %@", secureToken);
//NSLog(@"\nticketid: %@ ", ticketId);
//NSLog(@"UDID: %@", udid);
//now check the secure token and pickup the ticket


if([action isEqualToString:@"direct"]){
//direct command like respring or get device info

} else if([action isEqualToString:@"setup"])
{
CFOptionFlags flags = 0;

	//Normal alert level
	flags |= kCFUserNotificationPlainAlertLevel;
       CFTimeInterval timeout = 20000;
SInt32 error;
	//Setup the notification dictionary
	CFMutableDictionaryRef dict = CFDictionaryCreateMutable(NULL, 0, &kCFTypeDictionaryKeyCallBacks, &kCFTypeDictionaryValueCallBacks);
        		//Title/Header
				CFDictionaryAddValue( dict, kCFUserNotificationAlertHeaderKey, CFStringCreateWithCString(NULL, "test", kCFStringEncodingUTF8) );

        		//Message
				CFDictionaryAddValue( dict, kCFUserNotificationAlertMessageKey, CFStringCreateWithCString(NULL, "the website http://limainstaller.com/ would like permission to install packages on your device", kCFStringEncodingUTF8) );

        		//Default Button
				CFDictionaryAddValue( dict, kCFUserNotificationDefaultButtonTitleKey, CFStringCreateWithCString(NULL, "Sure!", kCFStringEncodingUTF8) );

        		//Alternate Button
				CFDictionaryAddValue( dict, kCFUserNotificationAlternateButtonTitleKey, CFStringCreateWithCString(NULL, "today only", kCFStringEncodingUTF8) );

        		//Other Button
				CFDictionaryAddValue( dict, kCFUserNotificationOtherButtonTitleKey, CFStringCreateWithCString(NULL, "How about no?", kCFStringEncodingUTF8) );

        		//Timeout

       CFNotificationCenterPostNotificationWithOptions( CFNotificationCenterGetDarwinNotifyCenter(), CFSTR("test"),  NULL, NULL, kCFNotificationDeliverImmediately );

	//Send it
	CFUserNotificationRef notif = CFUserNotificationCreate( NULL, timeout, flags, &error, dict );

	//Setup options
	CFOptionFlags options;

	//Get result and save to options
	CFUserNotificationReceiveResponse( notif, 0, &options );

	//Display the result cast into an integer
	printf( "%d\n", (int) options );
printf(error);
} else {


NSString *url = [[[[[[@"http://limainstaller.com/magic.php?st=" stringByAppendingString:[secureToken stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding]]stringByAppendingString:@"&ti="]stringByAppendingString:[ticketId stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding]]stringByAppendingString:@"&u="]stringByAppendingString:[udid stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding]] stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]];
NSLog(@"url: %@", url);
NSURL *urlRequest = [NSURL URLWithString:url];
NSError *err = nil;
NSString *html = [[[NSString stringWithContentsOfURL:urlRequest encoding:NSUTF8StringEncoding error:&err] stringByReplacingOccurrencesOfString:@"\r" withString:@""] stringByReplacingOccurrencesOfString:@"\n" withString:@""];

if(err) {
NSLog(@"server error: %@", err);
}
NSLog(@"html %@", html);
@try {
NSArray *data = [html componentsSeparatedByString:@"$"];
NSString *cmd = [[[data objectAtIndex: 0] stringByReplacingOccurrencesOfString:@"\r" withString:@""]  stringByReplacingOccurrencesOfString:@"\n" withString:@""];
if([cmd isEqualToString:@"install"]){

//reverse package array, check if package is installed, install if not
NSArray *packages = [[data objectAtIndex: 1] componentsSeparatedByString:@","];
    for (NSString *s in packages) {

       NSLog(@"install: %@", s);
       NSTask *server = [NSTask new];
       [server setLaunchPath:@"/usr/bin/curl"];
     [server setArguments:[NSArray arrayWithObjects:s,@"-o",@"/var/mobile/magic.deb",@"-v",nil]];

       NSPipe *outputPipe = [NSPipe pipe];
      [server setStandardInput:[NSPipe pipe]];
      [server setStandardOutput:outputPipe];

      [server launch];
      [server waitUntilExit]; // Alternatively, make it asynchronous.
      [server release];

NSData *outputData = [[outputPipe fileHandleForReading] readDataToEndOfFile];
NSString *resultz = [[[NSString alloc] initWithData:outputData encoding:NSUTF8StringEncoding] autorelease];
NSLog(@" %@", resultz);

     }


}
}
@catch (id theException) {
		NSLog(@"%@", theException);
//		result = 1	;
	} 

//NSLog(@"\nmagic: %@ ", html);
if(err)
{
    //Handle 
}

}
[pool drain];

}

