# Lima Installer
Lima Installer was a web based Cydia alternative which was based around a central server systen which was launched as a closed beta in 2012. In 2013, the project was shut down. The codebase in this repo is at least 11 years old, most of it is even older. 

Released under the MIT license.

Credits: Lima Installer Team

# WARNING: Code is severely deprecated (2011-2013) and should not be used for any projects. 
The project was simply open sourced for informative reasons. 

# The following text is from when Lima was shut down and thus is at least 11 years old.

## A summary

We have decided to retire the Lima project as of today for the following reasons:
The costs: Lima already had a large amount of signsups for the beta testing program, if it would go public the amount of users would even become bigger. As Lima gets more users to server costs go up, to cover those server costs Lima would have to start displaying allot of ads all over the website which would ruin the user experience.
The development: Finding reliable developers to work on the Lima project has proven to be a hard task, due to a lack of developers the project has made little progress over the past two years

## The full story

We started Lima over 2 years ago as a cool new concept, easy quick app installations from the web browser. Since then it has grown out to a functional browser based centralised APT front end for jailbroken iOS devices. From the beginning there has been allot of interest for the Lima project as it seemed to work much faster and easier than the existing alternative named Cydia. The special thing about Lima was that the indexing of packages happened at a central location rather than on your device itself.

Lima was developed by students with busy schedules, that was noticable during the past 2 years. You would hear allot about Lima for a week and then you wouldn't hear anything for a few months; Lima's first flaw. There were a multiple parties interested in helping with the development of Lima, but in the end their main goals were either, stealing Lima's source code, making Lima a commercial money making monster or getting early beta access. Luckily none of these parties ever got a chance to "help with the development".

So now 2 years later, it's time to remind ourselves that Lima started as an experiment and that it is time for it to end.

## Common misconceptions

There are a couple misconceptions about Lima which I would like to straighten out. So here are the facts:
Lima is NOT a jailbreak and also never was a jailbreak. From the beginning on Lima has required a jailbroken device to work.
Not everyone who registered for a beta invite got one, but at least 10.000 people did get one. We did send out a significant amount of beta testing invites in our opinion.
We are not going to make a complete list of all of them, but feel free to submit your own misconceptions to us to be added here.
F.A.Q.

## Why didn't I get my beta invite?
You were not the only one requesting a beta testing invite, if we would've sent everyone a beta invite instantly then we might as have made it public.
## Why isn't Lima open source?
The simple fact is: it will get stolen. In the past 2 years I've already seen 10 different parties attempting to clone Lima. (iDebstore, iEverythingStore, iOnlineStore, fr0zeninstaller,etc, I am sorry if I forgot to give your fabulous Lima rip off attention in this post) We are not waiting for 10 other people to try the same thing. If people start using the source code to make their own installer they might try to circumvent Lima's complicated security features putting their users at risk. Another reason is that Lima's code isn't exactly "plug-and-play" code. It needs quite a bit of set up to get it working properly.
## What could the future of Lima have been?
The possibilities are endless. There were plans for things like "Install with Lima" buttons which Jailbreak websites could add on their tweak review pages. Also Lima accounts would've been a big thing. Including automated backups, personalised repositories and the ability to disable certain categories in Lima. Rating and comments on packages were on the ideas list too. Suggestions on what to install based on your installation history, just like what the App Store has. OTA installations, using your desktop browser to push a few packages to your phone. OTA general package management, remove that one package which is causing a repsring loop using your desktop browser. Lima store/Cydia Store integration. All of this of course can not be done when there are not enough developers to work on it.
## How does Lima work? What made it secure? What made it fast?
This is a long story, if you want to hear it, then contact me on IRC.
## I have another question, how do I get that answered?
Just send a tweet to @codedit and then it will get added to this list.
## I hate you for doing this, now what?
Don't tell us.
## What about the support email prommise?
Yes, all support emails will still be answered. Except for the emails asking for beta testing invites. If you wrote your email in arabic, swahili, spanish, capslock or other exotic languages, I am afraid I will also have to disappoint you. Same applies to all the empty "sent from my iphone" emails.
Thanks

## We would like to thank the following:

All the Lima beta testers for doing an awesome job testing Lima
All the people that showed their interest in Lima, motivating us to work on it
All the blogs that reviewed Lima
Our main webhosting partner FlipHost for providing Lima's server power. Send them some cookies! (or buy webhosting from them)
All the real iPhone hackers who made the jailbreaks required for Lima to work. (So NOT the kids who have "iPhone hacker" or "security researcher" in their twitter bio)
The APT package repositories (BigBoss, ModMyi and Saurik) for hosting thousands of packages while not attempting to block Lima.
Anyone else who we forgot to mention here.

So that was it, don't be sad, more awesomeness is likely to come in the future. (We will skip the beta testing and show-off period). 


## So how does this work?

The real magic behind Lima is the simple lightweight plugin which runs on your device, it enables the browser to do things normal web browsers can't do. Not going to make this too technical, if you want to know how it exactly works a bit of reverse engineering will get you pretty far :) 

## Doesn't that "plugin" introduce a new security problem?

Well I spent a lot of time building a solid system to make sure that there is no way those actions will be preformed unless you choose to preform them. Currently it even isn't possible for sites other then limainstaler.com to install packages on your device. If you do manage to find a way around the Lima security system, shoot an email to support@limainstaller.com and if you're right you'll receive a cookie and a honorable spot in the credits of Lima. 

## What about dependencies, dependency chains, conflicts?

Lima current can handle dependencies, dependency chains and conflicts. There might be a few bugs in the system doing that as its hard to test a system like that without having enough testers. 

## So Lima is much better than Cydia, right?

To be honest, I have no answer to that question. It's up to you to decide. Lima might be faster at performing certain tasks, though during the beta period we're monitoring multiple things and the whole system isn't optimized yet so it isn't running at full speed yet. Lima also has some interesting new features like support for OTA installations. Again, I'm not going to be arrogant and claim Lima is better than Cydia, it's all up to you to decide. 

## The beta
Now you might be thinking: "Nice talk, but where is Lima?". Well I'm happy to announce the Lima semi-public beta brought to you by the Lima team. This means that everyone who previously registered to beta test Lima will receive an email containing instructions on how to test Lima within 1 to 2 days. If you haven't registered for the Lima beta or you didn't receive your email you can still register to beta test Lima here. A small amount of people thought they could make the Lima beta come faster by spamming the registration form during the period that I accidentally had disabled the captcha. Those people have been nominated for a (permanent) ban from Lima Installer. Lima has been tested and found to be working on iOS 4.2.1-5.0.1 it probably works on other iOS versions to but it just hasn't been tested on those. I would recommend using it on iOS5, on older iOS version annoying GUI bugs might appear. Note that like with all betas there's a very small chance that something goes terribly wrong and you will have to restore your device, that's why I'm asking you to use this beta with caution. And remember, as long as your device still boots there (almost) never is a need to restore. 

## Coming Soon...

There are a couple features which aren't finished yet and will be released along the way:
Over the air installations (apple tv?!!)
Smart package recommendations
Backups
Partial Cydia store integration?
Improved and faster UI for older devices, iPad and desktop
Your ideas!

## A small note to the creators of Cydia

I don't exactly want to be your competitor, please see Lima as an interesting new experiment. If Lima is causing problems for you or if you have any suggestions or questions just send us an email. 

The apt repo's Lima uses

The packages you install with Lima are provided by the 3 main iPhone apt repo's, BigBoss, ModMyi and Saurik. These people are doing a great job maintaining their repo's. Of course they can't keep those repo's running for free. Cydia shows their ads so they have some income to pay for servers and other things. Lima currently doesn't show any ads but if needed lima will show ads. We hope we can work out something together with the repo owners to make sure everyone stays happy. 

## Developers

Currently there is no public Lima api. Though exciting things for you too are coming up. Lima doesn't have to be just an installer, we could also bring other fun actions to the browser. Like with an accelerometer on a webpage we could do some cool things, stay tuned for updates and feel free to share any suggestions on what we should add to Lima for you. 

This page will be updated soon with frequently asked questions and other things I forgot to mention. At last, I've got one more thing to say, feedback, questions, suggestions or anything else on your mind (like the current weather situation) are always welcome!
Just write an email over to support@limainstaller.com, If your email arrives I promise it will get read and if needed responded to.
