import discord
import datetime
import random
import requests
from bs4 import BeautifulSoup
#import openai

from discord.ext import commands
from discord import Interaction

 


bot = commands.Bot(command_prefix=".", intents=discord.Intents.all(), status=discord.Status.online, activity=discord.Game(name="Reniec!"))



@bot.event
async def on_ready():
	await bot.tree.sync()
	print(f"conectado como {bot.user}")
@bot.command()
async def oe(ctx):
	await ctx.send("q ctm!")





@bot.command()
async def buscar(ctx, *, nombre: str):
    url = f"http://xxxx.zidrave.net/reniec/buscar.php?busqueda={nombre.replace(' ', '+')}"
    response = requests.get(url)
    if response.status_code == 200:
        soup = BeautifulSoup(response.content, "html.parser")
        resultado = soup.prettify()
        await ctx.send(resultado)
    else:
        await ctx.send("Error al obtener la información.")






@bot.command()
async def ip(ctx):
	await ctx.send("La ip es ** McZidrave.aternos.me:43795 **  ")







@bot.command()
async def hora(ctx):
	fha = datetime.datetime.now()
	xfha2 = datetime.datetime.utcnow() - datetime.timedelta(hours=5)

	lahora = xfha2.strftime ("%I : %M %p" )
	syshora = fha.strftime ("%I : %M %p")
	await ctx.send(" La hora en Peru es ** {} ** y la hora del sistema es ** {} **  ".format(lahora,syshora))


@bot.command()
async def soy(ctx, nombre):
	await ctx.send("Hola como vas {}? ".format(nombre))



 

@bot.command()
async def quienes(ctx, gil):
	palabras = ["gil", "gilazo", "wevas", "tipaso", "adicto", "vicioso", "enfermo", "loco"]
	palabra_aleatoria = random.choice(palabras) 
	await ctx.send("{} es un {}" .format(gil, palabra_aleatoria))
	#await ctx.send("es un wevas")


@bot.command()
async def dimelo(ctx, gil):
	palabras = ["gil", "gilazo", "wevas", "tipaso", "adicto", "vicioso", "enfermo", "loco"]
	palabra_aleatoria = random.choice(palabras) 
	await ctx.send("{} es un {}" .format(gil, palabra_aleatoria))
	#await ctx.send("es un wevas")

@bot.command()
async def dime(ctx, pregunta):
	api_key = "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"
	openai.api_key = api_key
	pregunta = pregunta
	respuesta = openai.Completion.create(
    	model="text-davinci-003",
    	prompt=pregunta,
    	max_tokens=50
	)

	#await ctx.send("Resp: {}! ".format(respuesta))
	await ctx.send("Resp: {}! ".format(respuesta.choices[0].text.strip()))




@bot.tree.command()
async def ping(interaction : Interaction):
	bot_latency = round(client.latency*1000)
	await interaction.response.send_message(f"pong! .... {bot_latency}ms")

bot.run("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx--crea-tu-token-----xxxxxxxxxxx")
