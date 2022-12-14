/****** Object:  Table [dbo].[previosConsolidados]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[previosConsolidados](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[aduanaDespacho] [varchar](5) NULL,
	[tipoOperacion] [varchar](250) NULL,
	[clave] [varchar](5) NULL,
	[rfc] [varchar](13) NULL,
	[aduanaEntrada] [varchar](5) NULL,
	[curpImportador] [varchar](18) NULL,
	[curpApoderado] [varchar](18) NULL,
	[destino] [varchar](250) NULL,
	[rfcAgente] [varchar](13) NULL,
	[pedimento_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_previosConsolidados] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
